<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawInfo extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'store_id', 'withdraw_qty', 'withdraw_date', 'created_at'
    ];
}
