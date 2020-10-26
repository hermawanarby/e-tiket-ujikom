<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\TransportationType;
use Validator;

class TransportationTypeControl extends Controller
{
    public function data(Request $req)
    {
        $data = TransportationType::where('description', 'like', "%$req->cari%")->paginate(10);
        return view('pages.transportation-type.data', ['data'=>$data, 'cari'=>$req->cari]);
    }

    public function tambah($value='')
    {
        return view('pages.transportation-type.tambah');
    }

    public function simpan(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'deskripsi'=>'required|between:3,50',
        ]);

        if($valid->fails())
        {
            return redirect()->route('transportation-type.tambah')
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = TransportationType::create([
            'description'=>$req->deskripsi,
        ]);

        if ($result) {
            return redirect()->route('transportation-type.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function hapus(Request $req)
    {
        $result = TransportationType::where('id', $req->id)->delete();

        if ($result) {
            return redirect()->route('transportation-type.data')->with('status-alert', 'sukses-hapus');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function edit(Request $req)
    {
        $result = TransportationType::where('id', $req->id)->first();
        return view('pages.transportation-type.edit', ['field'=>$result]);
    }

    public function update(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'deskripsi'=>'required|between:3,50',
        ]);

        if($valid->fails())
        {
            return redirect()->route('transportation-type.edit', ['id'=>$req->id])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = TransportationType::where('id', $req->id)
                    ->update([
                        'description'=>$req->deskripsi,
                    ]);
        
        if ($result) {
            return redirect()->route('transportation-type.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

}
