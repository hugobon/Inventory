<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $table = 'address';
    protected $guarded = []; //means allow all expect the fields mentioned here
}