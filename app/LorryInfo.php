<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LorryInfo extends Model
{
    protected $fillable = [
        'item_id', 'total_weight', 'arrived_unit', 'created_unit', 'purchase_cost','labour_cost', 'lorry_cost', 'lorry_no', 'unit_returned', 'created_at'
    ];
}
