<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_in extends Model
{
    protected $table = 'stock_in';
    protected $guarded = []; //means allow all expect the fields mentioned here

    public function totalProduct()
    {
        return $this->hasMany('App\product_serial_number','stock_in_id');
    }

}
