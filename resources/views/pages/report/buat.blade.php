@extends('layouts.main')
@section('content')
    <h1>Laporan</h1>
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
        <div class="card-header bg-info text-white">Buat Laporan</div>
            <div class="card-body">
                <form action="{{ route('report.render') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label>Dari Tanggal</label>
                            <div class="input-group date" id="tanggal_dari" data-target-input="nearest">
                                <input type="text" name="tanggal_dari" value="{{ Request::old('tanggal_dari') }}" class="form-control {{ $errors->has('tanggal_dari')?'is-invalid':'' }}" data-target="#tanggal_dari" required>

                                <div class="input-group-append" data-target="#tanggal_dari" data-toggle="datetimepicker">
                                    <span class="input-group-text">
                                        <i class="fa fa-aw fa-calendar-alt"></i>
                                    </span>
                                </div>

                                @if ($errors->has('tanggal_dari'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tanggal_dari') }}
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>Sampai Tanggal</label>
                            <div class="input-group date" id="tanggal_sampai" data-target-input="nearest">
                                <input type="text" name="tanggal_sampai" value="{{ Request::old('tanggal_sampai') }}" class="form-control {{ $errors->has('tanggal_sampai')?'is-invalid':'' }}" data-target="#tanggal_sampai" required>

                                <div class="input-group-append" data-target="#tanggal_sampai" data-toggle="datetimepicker">
                                    <span class="input-group-text">
                                        <i class="fa fa-aw fa-calendar-alt"></i>
                                    </span>
                                </div>

                                @if ($errors->has('tanggal_sampai'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tanggal_sampai') }}
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
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        <div class="card-footer bg-info"></div>   
    </div>
    <!-- Akhir Formulir -->

@endsection

@push('css')  
    <link rel="stylesheet" href="{{url('vendor/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}">    
@endpush

@push('js')
<script type="text/javascript" src="{{url('vendor/tempusdominus/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{url('vendor/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script type="text/javascript">
    $(function(){
        $('#tanggal_dari').datetimepicker({
            icons : {
                time : "fa fa-aw fa-clock",
                date : "fa fa-aw fa-calendar-alt",
                up : "fa fa-aw fa-arrow-up",
                down : "fa fa-aw fa-arrow-down",
            },

            format : "YYYY-MM-DD"
        });

        $('#tanggal_sampai').datetimepicker({
            icons : {
                time : "fa fa-aw fa-clock",
                date : "fa fa-aw fa-calendar-alt",
                up : "fa fa-aw fa-arrow-up",
                down : "fa fa-aw fa-arrow-down",
            },

            format : "YYYY-MM-DD",
            useCurrent : false,
        });

        $('#tanggal_dari').on('change.datetimepicker', function(e){
            $('#tanggal_sampai').datetimepicker('minDate', e.date);
        });

        $('#tanggal_sampai').on('change.datetimepicker', function(e){
            $('#tanggal_dari').datetimepicker('maxDate', e.date);
        });
    });
</script>
@endpush
