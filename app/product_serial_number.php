<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_serial_number extends Model
{
    use SoftDeletes;
    protected $table = 'product_serial_number';
    protected $guarded = []; //means allow all expect the fields mentioned here    

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\stock_in');
    }
}
