<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    
    protected $fillable = [
        'name', 'item_name', 'mobile_no', 'qty', 'monthly_amount', 'floor', 'block', 'storage_date', 'remain_qty', 'payable_amount','description'
    ];
}
