<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barcode extends Model
{
    protected $table = 'barcode';
    protected $guarded = []; //means allow all expect the fields mentioned here
}
