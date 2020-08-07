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
                    ->where('bill_date', '>=', date('Y-m-d',strtotime("-30 days")))
                    ->where('item_id', $item['item_id'])
					->where('bill_no', 'regexp', '^[A-Z]')
                    ->groupBy('bill_date')
                    ->get();

            if($sales->isEmpty()) {
                $result = [
                    "item_id" => $item['item_id'],
                    "bill_date" => date("Y-m-d"),
                    "total_qty" => "0",
                    "total_amount" => "0",
                ];
                $sales = [(object) $result];
            }

            $item['sales'] = $sales;
            // dd($sales);
        }

        return view('home', compact('items'));
    }
}
