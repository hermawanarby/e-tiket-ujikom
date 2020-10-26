@extends('layouts.main')
@section('content')
    <h1>Transportasi</h1>
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
        <div class="card-header bg-info text-white">Tambah Transportasi</div>
            <div class="card-body">
                <form action="{{ route('transportation.simpan') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="tipe">Tipe Transportasi</label>
                        <div class="row">
                            <div class="col-sm-4">

                                <select name="tipe" id="tipe" class="form-control {{ $errors->has('tipe') ? 'is-invalid':'' }}" required autofocus>
                                    <option value="">Pilih</option>
                                    @php
                                        $val = Request::old('tipe');
                                        $res = App\TransportationType::orderBy('description', 'asc')->get();
                                    @endphp
                                    @foreach ($res as $opt)
                                        <option value="{{ $opt->id }}" {{ $val == $opt->id?'selected':'' }}>
                                            {{ $opt->description }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @if ($errors->has('tipe'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('tipe')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kode">Kode / Nama Transportasi</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="kode" id="kode" class="form-control {{$errors->has('kode')?'is-invalid':''}}" value="{{Request::old('kode')}}" required>
                                
                                @if ($errors->has('kode'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('kode')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 3-50, Contoh: Pandawa Lima
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control {{$errors->has('deskripsi')?'is-invalid':''}}" value="{{Request::old('deskripsi')}}" required>
                                
                                @if ($errors->has('deskripsi'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('deskripsi')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 3-50, Contoh: PT. Garuda Indonesia
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="kapasitas">Kapasitas Tempat Duduk</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="number" name="kapasitas" id="kapasitas" class="form-control {{$errors->has('kapasitas')?'is-invalid':''}}" value="{{Request::old('kapasitas')}}" required>
                                
                                @if ($errors->has('kapasitas'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('kapasitas')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 1-5, Contoh: 100
                        </small>
                    </div>

                    <hr>
                    <div class="form-group text-right">
                        <p>
                            Pilih "Simpan" apabila menyimpan data yang  dimasukan pada formulir diatas.
                        </p>
                        <a href="{{route('transportation.data')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        <div class="card-footer bg-info"></div>   
    </div>
    <!-- Akhir Formulir -->

@endsection