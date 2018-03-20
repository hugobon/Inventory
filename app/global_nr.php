<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class global_nr extends Model
{
    protected $table = 'global_nr';
    protected $guarded = []; //means allow all expect the fields mentioned here
}