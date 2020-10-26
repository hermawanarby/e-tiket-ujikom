<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Rute;
use Validator;

class RuteControl extends Controller
{
    public function data(Request $req)
    {
        $cari = $req->cari;
        $data = Rute::where('transportation_type.id', 'like', "%$req->tipe%")
                ->where(function($query) use ($cari) {
                    $query->orWhere('rute.rute_from', 'like', "%$cari%")
                    ->orWhere('rute.rute_to', 'like', "%$cari%")
                    ->orWhere('transportation.code', 'like', "%$cari%");
                })
                ->join(
                    'transportation',
                    'transportation.id',
                    '=',
                    'rute.transportationid'
                )
                ->join(
                    'transportation_type',
                    'transportation_type.id',
                    '=',
                    'transportation.transportation_typeid'                    
                )
                ->select(
                    'rute.*',
                    'transportation.*',
                    'transportation_type.*',
                    'rute.id as id',
                    'transportation.id as id_trans',
                    'transportation_type.id as id_type',
                    'transportation.description as desc_transportation',
                    'transportation_type.description as desc_type',
                    'transportation.seat_qty as seat_qty_trans',
                    'rute.seat_qty as seat_qty_rute'
                )
                ->paginate(10);
                return view('pages.rute.data', ['cari'=>$req->cari, 'tipe'=>$req->tipe, 'data'=>$data]);
    }

    public function tambah(Request $req)
    {
        return view('pages.rute.tambah', ['trans_id'=>$req->id_trans]);
    }

    public function simpan(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'rute_from'=>'required|between:3,50',
            'rute_to'=>'required|between:3,50',
            'harga'=>'required|digits_between:5,10|numeric',
            'lama'=>'required|digits_between:1,3|numeric',
        ]);

        if($valid->fails())
        {
            return redirect()->route('rute.tambah', ['trans_id'=>$req->trans])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = Rute::create([
            'rute_from'=>$req->rute_from,
            'rute_to'=>$req->rute_to,
            'price'=>$req->harga,
            'depart_at'=>$req->lama,
            'transportationid'=>$req->trans,
            'seat_qty'=>$req->kapasitas,
        ]);

        if ($result) {
            return redirect()->route('rute.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function hapus(Request $req)
    {
        $result = Rute::where('id', $req->id)->delete();

        if ($result) {
            return redirect()->route('rute.data')->with('status-alert', 'sukses-hapus');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function edit(Request $req)
    {
        $result = Rute::where('id', $req->id)->first();
        return view('pages.rute.edit', ['field'=>$result]);
    }

    public function update(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'transportasi'=>'required|numeric',
            'rute_from'=>'required|between:3,50',
            'rute_to'=>'required|between:3,50',
            'harga'=>'required|digits_between:5,10|numeric',
            'lama'=>'required|digits_between:1,3|numeric',
        ]);

        if($valid->fails())
        {
            return redirect()->route('rute.edit', ['id'=>$req->id])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = Rute::where('id', $req->id)
                    ->update([
                        'rute_from'=>$req->rute_from,
                        'rute_to'=>$req->rute_to,
                        'price'=>$req->harga,
                        'depart_at'=>$req->lama,
                        'transportationid'=>$req->transportasi,
                    ]);
        
        if ($result) {
            return redirect()->route('rute.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

}
