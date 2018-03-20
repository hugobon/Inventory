<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class global_status extends Model
{
    protected $table = 'global_status';
    protected $guarded = []; //means allow all expect the fields mentioned here
}