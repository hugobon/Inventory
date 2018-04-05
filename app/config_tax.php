<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class config_tax extends Model
{
    protected $table = 'config_tax';
    protected $guarded = []; //means allow all expect the fields mentioned here
}