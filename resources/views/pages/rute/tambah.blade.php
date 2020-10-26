@extends('layouts.main')
@section('content')
    <h1>Rute</h1>
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
    {{--  --}}
    @php
        $trans=App\Transportation::join('transportation_type', 'transportation_type.id', '=', 'transportation.transportation_typeid')
        ->select(
            'transportation.*',
            'transportation_type.*',
            'transportation.id as id',
            'transportation_type.id as typeid',
            'transportation.description as desc_trans',
            'transportation_type.description as type'
        )
        ->where('transportation.id', $trans_id)->first();
    @endphp
    
    <!-- Formulir -->
    <div class="card border-info mb-3">
        <div class="card-header bg-info text-white">Tambah Rute</div>
            <div class="card-body">
                <form action="{{ route('rute.simpan') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="trans" value="{{ $trans_id }}">
                    <input type="hidden" name="kapasitas" value="{{ $trans->seat_qty }}">

                    <div class="form-group">
                        <label>Kapasitas Kursi</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="text" class="form-control " value="{{ $trans->seat_qty }}" disabled>

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="rute_from">Berangkat Dari</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="rute_from" id="rute_from" class="form-control {{$errors->has('rute_from')?'is-invalid':''}}" value="{{Request::old('rute_from')}}" required>
                                
                                @if ($errors->has('rute_from'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('rute_from')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 3-50, Contoh: Bandung
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="rute_to">Tujuan Ke</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="rute_to" id="rute_to" class="form-control {{$errors->has('rute_to')?'is-invalid':''}}" value="{{Request::old('rute_to')}}" required>
                                
                                @if ($errors->has('rute_to'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('rute_to')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 3-50, Contoh: Yogyakarta
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="lama">Lama Perjalanan (Jam)</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="number" name="lama" id="lama" class="form-control {{$errors->has('lama')?'is-invalid':''}}" value="{{Request::old('lama')}}" required>
                                
                                @if ($errors->has('lama'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('lama')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 1-2, Contoh: 2
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="number" name="harga" id="harga" class="form-control {{$errors->has('harga')?'is-invalid':''}}" value="{{Request::old('harga')}}" required>
                                
                                @if ($errors->has('harga'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('harga')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <small>
                            Panjang karakter 5-10, Contoh: 250000
                        </small>
                    </div>

                    <hr>
                    <div class="form-group text-right">
                        <p>
                            Pilih "Simpan" apabila menyimpan data yang  dimasukan pada formulir diatas.
                        </p>
                        <a href="{{route('rute.data')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        <div class="card-footer bg-info"></div>   
    </div>
    <!-- Akhir Formulir -->

@endsection