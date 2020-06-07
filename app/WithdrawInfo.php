<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawInfo extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'batch_id', 'store_id', 'bill_no','withdraw_qty', 'withdraw_date', 'lorry_no', 'created_at', 'description'
    ];
}
