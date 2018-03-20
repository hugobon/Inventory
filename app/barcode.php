<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class barcode extends Model
{
    use SoftDeletes;
    protected $table = 'barcode';
    protected $guarded = []; //means allow all expect the fields mentioned here    

    protected $dates = ['deleted_at'];
}
