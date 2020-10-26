<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportationType extends Model
{
    protected $table = 'transportation_type';
    public $timestamps = false;
    protected $fillable = ['description'];
}
