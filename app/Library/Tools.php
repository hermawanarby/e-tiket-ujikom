<?php
namespace App\Library;

use App\Reservation;

class Tools 
{
    function coderes()
    {
        $data = Reservation::orderBy('id', 'desc')->first();
        $no = count($data) <= 0 ? 1 : $data->id + 1;
        if ($no < 10) {
            $no = '00' . $no;
        } elseif ($no < 100) {
            $no = '0' . $no;
        }
        return 'TTS'.date('Ymd').$no;
    }

    public function dateformat($date, $format)
    {
        return date_format(date_create($date), $format);
    }

    public function interval($berangkat, $jam, $format)
    {
        $date = date_create($berangkat);
        date_modify($date, '+' . $jam . 'hours');
        return date_format($date, $format);
    }

}
