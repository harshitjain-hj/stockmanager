<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'bill_no', 'customer_id', 'item_id', 'qty', 'amount', 'total_amount', 'bill_date', 'description'
    ];
}
