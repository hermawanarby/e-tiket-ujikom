<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    protected $table = 'rute';
    public $timestamps = false;
    protected $fillable = [
                            'id',
                            'depart_at',
                            'rute_from',
                            'rute_to',
                            'price',
                            'seat_qty',
                            'transportationid',
                        ];
}
