<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Stock;
use App\Sale;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Stock::select('item_id', 'unit_remain', 'name')
                    ->join('items', 'items.id', 'stocks.item_id')
                    ->get();
        foreach($items as $item) {
            $sales = Sale::selectRaw('item_id, bill_date, sum(qty) as total_qty, sum(total_amount) as total_amount')
                    ->where('bill_date', '>=',date('Y-m-d',strtotime("-20 days")))
                    ->where('item_id', $item['item_id'])
                    ->groupBy('bill_date')
                    // ->orderBy('bill_date', 'desc')
                    ->get();

            $item['sales'] = $sales;
            // dd($sales);
        }
        // $sales = Sale::selectRaw('item_id, bill_date, sum(qty) as total_qty, sum(total_amount) as total_amount')
        //             ->where('bill_date', '>=',date('Y-m-d',strtotime("-7 days")))
        //             ->groupBy('bill_date')
        //             ->orderBy('bill_date', 'desc')
        //             ->get();
        // dd(json_encode($items));
        return view('home', compact('items'));
    }
}
