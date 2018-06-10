<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_hdr extends Model
{
    protected $table = 'order_hdr';
    protected $guarded = []; //means allow all expect the fields mentioned here
}