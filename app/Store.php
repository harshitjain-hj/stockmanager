<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    
    protected $fillable = [
        'name', 'store_id', 'item_name', 'mobile_no', 'qty', 'monthly_amount', 'floor', 'block', 'storage_date', 'lorry_no','remain_qty', 'payable_amount', 'status', 'description'
    ];
}
