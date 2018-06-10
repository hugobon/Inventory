<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $table = 'supplier';
    protected $guarded = []; //means allow all expect the fields mentioned here
}