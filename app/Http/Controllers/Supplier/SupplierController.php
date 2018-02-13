<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function supplierDetail_page(){
    	return view('Supplier.supplierDetail');
    }

    public function stockIn_page(){
    	return view('Supplier.stockIn');
    }

    public function supplierDO_page(){
    	return view('Supplier.supplierDO');
    }
}
