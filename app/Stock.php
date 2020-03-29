<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'item_id', 'unit_remain', 'updated_at'
    ];
}
