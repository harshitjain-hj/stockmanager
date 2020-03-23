<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'sku', 'description', 'image'
    ];
    public $timestamps = false;
}
