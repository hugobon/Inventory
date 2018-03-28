<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class delivery_type extends Model
{
    protected $table = 'delivery_type';
    protected $guarded = []; //means allow all expect the fields mentioned here    

}