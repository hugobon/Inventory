<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class courier extends Model
{
    protected $table = 'courier';
    protected $guarded = []; //means allow all expect the fields mentioned here
}