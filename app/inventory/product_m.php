<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class product_m extends Model
{
    protected $table = 'product';


     /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeTotalProductCount($query)
    {
        return $query->leftjoin('stock_in','stock_in.stock_product','=','product.id')
        ->join('supplier','stock_in.stock_supplier','=','supplier.id')
        ->join('product_serial_number','stock_in.id','=','product_serial_number.stock_in_id')
        ->selectRaw('product.description as product_description,product.code as product_code, count(product.id) as stocksCount ,product.id as product_id')
        ->groupBy('product_description','product_code','product_id');
    }
}
