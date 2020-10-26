<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Reservation;
use Validator;

class ReportControl extends Controller
{
    public function invoice(Request $req)
    {
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
                ->where('reservation.reservation_code', $req->kode)
                ->first();

                return view('pages.report.invoice', ['field'=>$data]);
    }

    public function buat(Request $req)
    {
        return view('pages.report.buat');
    }

    public function render(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'tanggal_dari'=>'required|date_format:Y-m-d',
            'tanggal_sampai'=>'required|date_format:Y-m-d',
        ]);

        if($valid->fails())
        {
            return redirect()->route('report')
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }   

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
                ->where('reservation.reservation_date', '>=', $req->tanggal_dari)
                ->where('reservation.reservation_date', '<=', $req->tanggal_sampai)
                ->orderBy('reservation.id','asc')   
                ->get();
                return view('pages.report.render', ['data'=>$data, 'dari'=>$req->tanggal_dari, 'sampai'=>$req->tanggal_sampai]);
    }
}
