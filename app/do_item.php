<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class do_item extends Model
{
    protected $table = 'do_item';
    protected $guarded = []; //means allow all expect the fields mentioned here
}