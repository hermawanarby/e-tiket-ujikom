@extends('layouts.main')
@section('content')
    <h1>Pengguna</h1>
    <hr>

    <!-- Alert -->
    @if (session('status-alert') == 'peringatan')
    <div class="alert alert-warning alert-dismissble fade show" role="alert">
        <strong>Oups, ada kesalahan !</strong> Data gagal disimpan, karena ada kesalahan silahkan check kembali.
        <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status-alert') == 'gagal')
    <div class="alert alert-danger alert-dismissble fade show" role="alert">
        <strong>Gagal dihapus !</strong> Data gagal dihapus pada database, silahkan ulangi kembali.
        <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    @endif   
    <!-- Akhir Alert -->

    <div class="card border-info mb-3">
        <div class="card-header bg-info text-white">Edit Pengguna</div>
            <div class="card-body">
                <form action="{{ route('pengguna.update') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $field->id }}">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="nama" class="form-control {{$errors->has('nama')?'is-invalid':''}}" value="{{Request::old('nama', $field->fullname)}}" required autofocus>
                                
                                @if ($errors->has('nama'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('nama')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 8-50, Contoh: Hermawan Arby
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="username" class="form-control {{$errors->has('username')?'is-invalid':''}}" value="{{Request::old('username', $field->username)}}" required autofocus>
                                
                                @if ($errors->has('username'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('username')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 4-50, dan tidak boleh menggunakan spasi. <br>
                            Contoh: hermawan, hermawanarby, hermawan-arby, hermawan_arby, hermawan93
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="email" name="email" class="form-control {{$errors->has('email')?'is-invalid':''}}" value="{{Request::old('email', $field->email)}}" required>

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('email')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 8-50, Contoh: hermawanarby@gmail.com
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <div class="row">
                            <div class="col-sm-3">
                                @php
                                    $val = Request::old('level', $field->level)
                                @endphp
                                <select name="level" id="level" class="form-control {{ $errors->has('level') ? 'is-invalid':'' }}" required>
                                    <option value="" {{ $val == ''?'selected':'' }}>Pilih:</option>
                                    <option value="operator" {{ $val == 'operator'?'selected':'' }}>Operator</option>
                                    <option value="admin" {{ $val == 'admin'?'selected':'' }}>Admin</option>
                                </select>
                                
                                @if ($errors->has('level'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('level')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control {{$errors->has('password')?'is-invalid':''}}">

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('password')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Kosongkan Password apabila tidak akan diganti.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Ulangi Password</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="password" name="repassword" class="form-control {{$errors->has('repassword')?'is-invalid':''}}">

                                @if ($errors->has('repassword'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('repassword')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            
                        </small>
                    </div>

                    <hr>
                    <div class="form-group text-right">
                        <p>
                            Pilih "Simpan" apabila menyimpan data yang  dimasukan pada formulir diatas.
                        </p>
                        <a href="{{route('pengguna.data')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        <div class="card-footer bg-info"></div>   
    </div>

@endsection
