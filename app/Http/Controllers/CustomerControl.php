<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Customer;
use Validator;

class CustomerControl extends Controller
{
    public function data(Request $req)
    {
        $data = Customer::where('name', 'like', "%$req->cari%")->paginate(10);
        return view('pages.customer.data', ['data'=>$data, 'cari'=>$req->cari]);
    }

    public function tambah()
    {
        return view('pages.customer.tambah');
    }

    public function simpan(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'nama'=>'required|between:8,50',
            'alamat'=>'required|between:8,200',
            'telepon'=>'required|digits_between:8,12|numeric',
            'gender'=>'required|in:L,P',
        ]);

        if($valid->fails())
        {
            return redirect()->route('customer.tambah')
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = Customer::create([
            'name'=>$req->nama,
            'address'=>$req->alamat,
            'phone'=>$req->telepon,
            'gender'=>$req->gender,
        ]);

        if ($result) {
            return redirect()->route('customer.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function hapus(Request $req)
    {
        $result = Customer::where('id', $req->id)->delete();

        if ($result) {
            return redirect()->route('customer.data')->with('status-alert', 'sukses-hapus');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function edit(Request $req)
    {
        $result = Customer::where('id', $req->id)->first();
        return view('pages.customer.edit', ['field'=>$result]);
    }

    public function update(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'nama'=>'required|between:8,50',
            'alamat'=>'required|between:8,200',
            'telepon'=>'required|digits_between:8,12|numeric',
            'gender'=>'required|in:L,P',
        ]);

        if($valid->fails())
        {
            return redirect()->route('customer.edit', ['id'=>$req->id])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = Customer::where('id', $req->id)
                    ->update([
                        'name'=>$req->nama,
                        'address'=>$req->alamat,
                        'phone'=>$req->telepon,
                        'gender'=>$req->gender,
                    ]);
        
        if ($result) {
            return redirect()->route('customer.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }
}
