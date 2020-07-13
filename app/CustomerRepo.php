<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerRepo extends Model
{
    protected $fillable = [
        'customer_id', 'total_amount', 'remain_amount', 'remain_assets'
    ];
}
