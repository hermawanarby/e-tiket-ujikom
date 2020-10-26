<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Reservation;
use Validator;

class ReservationControl extends Controller
{
    public function data(Request $req)
    {
        $cari = $req->cari;

        $operator = Auth::user()->level != 'admin' ? true : false;
        $id_operator = Auth::user()->id;

        $data = Reservation::join('users', 'users.id', '=', 'reservation.userid')
                ->join('customer', 'customer.id', '=', 'reservation.customerid')
                ->join('rute', 'rute.id', '=', 'reservation.ruteid')
                ->join('transportation', 'transportation.id', '=', 'rute.transportationid')
                ->join('transportation_type', 
                        'transportation_type.id', 
                        '=', 
                        'transportation.transportation_typeid')
                ->select(
                    'reservation.*',
                    'users.*',
                    'customer.*',
                    'rute.*',
                    'transportation.*',
                    'transportation_type.*',
                    'reservation.id as id',
                    'users.id as id_user',
                    'customer.id as id_customer',
                    'rute.id as id_rute',
                    'transportation.id as id_transportation',
                    'transportation_type.id as id_transportation_type',
                    'reservation.depart_at as depart_at',
                    'rute.depart_at as depart_at_rute',
                    'reservation.price as price',
                    'rute.price as price_rute',
                    'transportation.description as description',
                    'transportation_type.description as type'
                )
                ->where(function($query) use ($cari){
                    $query->orWhere('reservation.reservation_code', 'like', "%$cari%")
                    ->orWhere('customer.name', 'like', "%$cari%");
                })
                ->when($operator, function($query) use ($id_operator){
                    return $query->where('users.id', $id_operator);
                })
                ->orderBy('reservation.id', 'desc')
                ->paginate(10);

                return view('pages.reservation.data', ['cari'=>$cari, 'data'=>$data]);
                
    }

    public function pesan(Request $req)
    {
        return view('pages.reservation.pesan', ['id_customer'=>$req->id_customer, 'id_type'=>$req->id_type]);
    }

    public function simpan(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'id_customer'=>'required|numeric',
            'rute'=>'required|numeric',
            'kode_reservasi'=>'required|between:8,190',
            'harga'=>'required|numeric|digits_between:3,10',
            'tanggal'=>'required|date_format:Y-m-d H:i:s',
            'tempat_duduk'=>'required|between:2,5|unique:reservation,seat_code,null,id,ruteid,'.$req->rute.',depart_at,'.$req->tanggal,
        ]);

        if($valid->fails())
        {
            return redirect()->route('reservation.pesan', [
                        'id_customer'=>$req->id_customer, 'id_type'=>$req->id_type
                    ])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = Reservation::create([
            'userid'=>Auth::user()->id,
            'customerid'=>$req->id_customer,
            'ruteid'=>$req->rute,
            'reservation_code'=>$req->kode_reservasi,
            'price'=>$req->harga,
            'depart_at'=>$req->tanggal,
            'seat_code'=>$req->tempat_duduk,
            'reservation_date'=>date('Y-m-d'),
            'reservation_at'=>date('H:i:s'),
            'jumlah'=>$req->jum,
        ]);

        if ($result) {
            return redirect()->route('reservation.data')
                    ->with('status-alert', 'sukses')
                    ->with('kode',$req->kode_reservasi);
        } else {
            return redirect()->route('reservation.pesan', [
                'id_customer'=>$req->id_customer, 'id_type'=>$req->id_type
            ])->with('status-alert', 'gagal');
        }
    }

}
