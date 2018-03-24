<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $table = 'order_item';
    protected $guarded = []; //means allow all expect the fields mentioned here
}