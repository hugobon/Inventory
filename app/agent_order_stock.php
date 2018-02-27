<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class agent_order_stock extends Model
{
    protected $table = 'agent_order_stock';
    protected $guarded = []; //means allow all expect the fields mentioned here
}