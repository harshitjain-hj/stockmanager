<?php

namespace App\Http\Controllers\Stock;

// Specific
use App\Stock;

// Helper
use App\Item;
use App\LorryInfo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = DB::table('stocks')->select('name','sku','description','unit_remain','updated_at')->join('items', 'stocks.item_id', 'items.id')->get();
        // dd($stock);
        return view('stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return view('stock.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lorry_info = request()->validate([
            'item_id' => 'required|numeric|unique:items',
            'created_at' => 'required|date',
            'total_weight' => 'required|numeric',
            'arrived_unit' => 'required|numeric',
            'created_unit' => 'nullable|numeric',
            'purchase_cost' => 'required|numeric',
            'labour_cost' => 'nullable|numeric',
            'lorry_cost' => 'nullable|numeric',
            'lorry_no' => 'string|nullable',
            'unit_returned' => 'nullable|numeric',
        ]);

        $stock = Stock::where(['item_id'=> $lorry_info['item_id']])->select('unit_remain', 'updated_at')->first();
        // dd($stock);
        if(empty($stock)) {
            $stockcreationdata = ([
                'item_id' => $lorry_info['item_id'],
                'unit_remain' => $lorry_info['created_unit'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            // dd($stockcreationdata);
            $stock = new Stock($stockcreationdata);
            $stock->save();

        } else {
            Stock::where(['item_id'=> $lorry_info['item_id']])->update([
                'unit_remain' => $stock['unit_remain'] + $lorry_info['created_unit'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $lorry_info = new LorryInfo($lorry_info);
        $lorry_info->save();
        return redirect('/lorryinfo');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
