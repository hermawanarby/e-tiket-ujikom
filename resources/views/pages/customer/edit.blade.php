@extends('layouts.main')
@section('content')
    <h1>Pelangggan</h1>
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

    <!-- Formulir -->
    <div class="card border-info mb-3">
        <div class="card-header bg-info text-white">Edit Pelanggan</div>
            <div class="card-body">
                <form action="{{ route('customer.update') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $field->id }}">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="nama" id="nama" class="form-control {{$errors->has('nama')?'is-invalid':''}}" value="{{Request::old('nama', $field->name)}}" required autofocus>
                                
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
                        <label for="alamat">Alamat</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <textarea name="alamat" id="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid':'' }}" rows="4" required>{{ Request::old('alamat', $field->address) }}</textarea>
                                
                                @if ($errors->has('alamat'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('alamat')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 8-200, Contoh: Jl. Raya Pangandaran No.15, Kec. Pangandaran.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="telepon">No Telepon/HP</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="number" id="telepon" name="telepon" class="form-control {{$errors->has('telepon')?'is-invalid':''}}" value="{{Request::old('telepon', $field->phone)}}" required>
                                
                                @if ($errors->has('telepon'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('telepon')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 8-12, Contoh: 888999555777
                        </small>
                    </div>

                    <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    @php
                                        $val = Request::old('gender', $field->gender)
                                    @endphp
                                    <select name="gender" id="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid':'' }}" required>
                                        <option value="" {{ $val == ''?'selected':'' }}>Pilih:</option>
                                        <option value="L" {{ $val == 'L'?'selected':'' }}>Laki-laki</option>
                                        <option value="P" {{ $val == 'P'?'selected':'' }}>Perempuan</option>
                                    </select>
                                    
                                    @if ($errors->has('gender'))
                                        <div class="invalid-feedback">
                                            {{$errors->first('gender')}}
                                        </div>
                                    @endif
    
                                </div>
                            </div>
                        </div>

                    <hr>
                    <div class="form-group text-right">
                        <p>
                            Pilih "Simpan" apabila menyimpan data yang  dimasukan pada formulir diatas.
                        </p>
                        <a href="{{route('customer.data')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        <div class="card-footer bg-info"></div>   
    </div>
    <!-- Akhir Formulir -->

@endsection