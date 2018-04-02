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
        return $query->leftjoin('product_serial_number','product.id','=','product_serial_number.product_id')
        ->leftjoin('stock_in','stock_in.id','=','product_serial_number.stock_in_id')
        ->join('supplier','stock_in.supplier_id','=','supplier.id')        
        ->selectRaw('product.name as product_name,product.description as product_description,product.code as product_code, count(product.id) as stocksCount ,product.id as product_id')
        ->groupBy('product_name','product_description','product_code','product_id','product.id');
    }
}
