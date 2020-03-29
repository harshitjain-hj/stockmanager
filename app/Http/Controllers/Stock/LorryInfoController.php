<?php

namespace App\Http\Controllers\Stock;

use App\LorryInfo;
use App\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LorryInfoController extends Controller
{
    public function index()
    {
        $lorry_infos = DB::table('lorry_infos')->join('items', 'lorry_infos.item_id', 'items.id')->get(array('lorry_infos.*', 'items.name'));
        // dd($lorry_infos);
        return view('stock.lorryinfo', compact('lorry_infos'));
    }
}
