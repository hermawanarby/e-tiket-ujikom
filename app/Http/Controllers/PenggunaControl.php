<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Validator;

class PenggunaControl extends Controller
{
    public function data(Request $r)
    {
        $data = User::where('fullname', 'like', "%$r->cari%")->paginate(10);
        return view('pages.pengguna.data', ['data'=>$data, 'cari'=>$r->cari]);
    }

    public function tambah()
    {
        return view('pages.pengguna.tambah');
    }

    public function simpan(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'nama'=>'required|between:4,50',
            'email'=>'required|between:8,50|email|unique:users,email',
            'username'=>'required|between:4,50|unique:users,username|alpha_dash',
            'password'=>'required|min:6',
            'repassword'=>'required|same:password',
            'level'=>'required|in:operator,admin',
        ]);

        if($valid->fails())
        {
            return redirect()->route('pengguna.tambah')
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $result = User::create([
            'fullname'=>$req->nama,
            'username'=>$req->username,
            'email'=>$req->email,
            'level'=>$req->level,
            'password'=>bcrypt($req->password),
        ]);

        if ($result) {
            return redirect()->route('pengguna.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function hapus(Request $req)
    {
        $result = User::where('id', $req->id)->delete();

        if ($result) {
            return redirect()->route('pengguna.data')->with('status-alert', 'sukses-hapus');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function edit(Request $req)
    {
        $result = User::where('id', $req->id)->first();
        return view('pages.pengguna.edit', ['field'=>$result]);
    }

    public function update(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'nama'=>'required|between:8,50',
            'email'=>'required|between:8,50|email|unique:users,email,'.$req->id,
            'username'=>'required|between:4,50|unique:users,username,'.$req->id.'|alpha_dash',
            'password'=>'nullable|min:6',
            'repassword'=>'nullable|same:password|required_with::password',
            'level'=>'required|in:operator,admin',
        ]);

        if($valid->fails())
        {
            return redirect()->route('pengguna.edit', ['id'=>$req->id])
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $colom = [
            'fullname'=>$req->nama,
            'username'=>$req->username,
            'level'=>$req->level,
            'email'=>$req->email,
        ];

        if (!empty($req->password) || $req->password != null || $req->password != '') {
            $colom['password'] = bcrypt($req->password);
        }

        $result = User::where('id', $req->id)
                    ->update($colom);
        
        if ($result) {
            return redirect()->route('pengguna.data')->with('status-alert', 'sukses');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

    public function setting()
    {
        $result = User::where('id', Auth::user()->id)->first();
        return view('pages.pengguna.setting', ['field'=>$result]);
    }
    
    public function settingUpdate(Request $req)
    {
        $valid = Validator::make($req->all(),[
            'nama'=>'required|between:8,50',
            'email'=>'required|between:8,50|email|unique:users,email,'.Auth::user()->id,
            'username'=>'required|between:4,50|unique:users,username,'.$req->id.'|alpha_dash',
            'password'=>'nullable|min:6',
            'repassword'=>'nullable|same:password|required_with::password',
        ]);

        if($valid->fails())
        {
            return redirect()->route('pengguna.setting')
                    ->withErrors($valid)
                    ->withInput()
                    ->with('status-alert', 'peringatan');
        }

        $colom = [
            'fullname'=>$req->nama,
            'username'=>$req->username,
            'email'=>$req->email,
        ];

        if (!empty($req->password) || $req->password != null || $req->password != '') {
            $colom['password'] = bcrypt($req->password);
        }

        $result = User::where('id', Auth::user()->id)
                    ->update($colom);
        
        if ($result) {
            return back()->with('status-alert', 'sukses-update');
        } else {
            return back()->with('status-alert', 'gagal');
        }
    }

}
