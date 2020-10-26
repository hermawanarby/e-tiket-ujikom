@extends('layouts.report')
@section('content')
    @php
        $tool = new App\Library\Tools;
    @endphp
    <div class="row">
        <div class="col">
            <table>
                <tr>
                    <td>Perihal</td> 
                    <td>: Laporan Reservasi</td>
                </tr>
                <tr>
                    <td>Dari Tanggal</td>
                    <td>: {{$tool->dateformat($dari, 'D, d M Y')}}</td>
                </tr>
                <tr>
                    <td>Sampai Tanggal</td>
                    <td>: {{$tool->dateformat($sampai, 'D, d M Y')}}</td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table>
                <tr>
                    <td>Total Record</td>
                    <td>: {{$data->count()}}</td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>: Rp. {{number_format($data->sum('price'),0,',','.')}}</td>
                </tr>
                <tr>
                    <td>Tanggal Dibuat</td>
                    <td>: {{date('D, d M Y - H:i:s')}}</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="table sm-3 table-striped mt-3">
        @foreach ($data as $field)
        <tr>
            <td>
                No : {{$field->reservation_code}} <br>
                Name : {{$field->name}} <br>
                <small><i>{{$tool->dateformat($field->reservation_date.' '.$field->reservation_at, 'D, d M Y - H:i:s')}} {{$field->fullname}}</i></small>
            </td>
            <td>
                {{$field->type}} : {{$field->code}} <br>
                <small>
                    Tempat Duduk: {{$field->seat_code}} <br>
                    {{$field->description}}
                </small>
            </td>
            <td>
                Rute : {{$field->rute_from}} <small class="fas fa-aw fa-arrow-alt-circle-right"></small> {{$field->rute_to}} <br>
                Rp. {{number_format($field->price,0,',','.')}} <br>
                <small>Jadwal : {{$tool->dateformat($field->depart_at, 'D, d M Y - H:i:s')}}</small>
            </td>
        </tr>
        @endforeach   
    </table>

@endsection