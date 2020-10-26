<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $table = 'transportation';
    public $timestamps = false;
    protected $fillable = ['code', 'description', 'seat_qty', 'transportation_typeid'];
}
