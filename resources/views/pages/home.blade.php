@extends('layouts.main')
@section('content')



<div class="row">
    @php
        $operator = Auth::user()->level != 'admin' ? true : false;
        $id = Auth::user()->id;
    @endphp

    @if (!$operator)
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
                @php
                    $data = App\User::all();
                @endphp
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-user"></i>
                </div>
                <div class="mr-5">{{$data->count()}} Pengguna!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('pengguna.data')}}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                @php
                    $data = App\Transportation::all();
                @endphp
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-plane"></i>
                </div>
                <div class="mr-5">{{$data->count()}} Transportasi!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('transportation.data')}}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    @endif

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                @php
                    $data = App\Customer::all();
                @endphp
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-users"></i>
                </div>
                <div class="mr-5">{{$data->count()}} Pelanggan!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('customer.data')}}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                @php
                    $data = App\Reservation::join('users', 'users.id', 'reservation.userid')
                            ->when($operator, function($query) use ($id){
                                return $query->where('users.id', $id);
                            })
                            ->get();
                @endphp
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                </div>
                <div class="mr-5">{{$data->count()}} Reservasi!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('reservation.data')}}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>

</div>

<!-- Area Chart Example-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-chart-area"></i>
        Chart Transaksi Reservasi
    </div>
    <div class="card-body">
        <canvas id="myAreaChart" width="100%" height="30"></canvas>
    </div>
</div>

@endsection

@push('js')
@php
    $data = App\Reservation::join('users', 'users.id', 'reservation.userid')
            ->when($operator, function($query) use ($id){
                return $query->where('users.id', $id);
            })
            ->select(
                'reservation.reservation_date as reservation_date', 
                'reservation.price as price'
                )
            ->get();
    $star_date = strtotime(date('Y-m-d'));  
    $date = strtotime("-10 days", $star_date);

    $x = 0;
    $data_tanggal = "";
    $data_transaksi = "";
    $data_price = "";
    while ($x < 10) {
        $x++;
        $date = strtotime("+1 days", $date);
        $tanggal = date('Y-m-d', $date);
        $tgl = date('d M', $date);
        $jum = $data->where('reservation_date', 'like', $tanggal)->count();
        $price = $data->where('reservation_date', 'like', $tanggal)->sum('price');
        $data_tanggal .= "'$tgl',";
        $data_transaksi .= "'$jum',";
    }

@endphp
<script type="text/javascript">
    var tanggal = [<?= $data_tanggal ?>];
    var transaksi = [<?= $data_transaksi ?>];
</script>
<script src="{{url('vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{url('js/demo/chart-area-demo.js')}}"></script>
@endpush