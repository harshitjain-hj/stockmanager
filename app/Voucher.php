<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'voucher_type', 'customer_id', 'item_data', 'asset_data', 'total_amount', 'amount_recieved', 'status', 'bill_no', 'outstanding', 'remark'
    ];
}
