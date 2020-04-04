<?php

namespace App\Http\Controllers\Store;

use App\Store;
use App\WithdrawInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = Store::all();
        return view('store.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_info = request()->validate([
            "name" => "required|string",
            "item_name" => "required|string",
            "mobile_no" => "required|regex:/[0-9]{10}/",
            "qty" => "required|numeric",
            "monthly_amount" => "required|numeric",
            "floor" => "required|integer|between:0,6",
            "block" => "required|string",
            "storage_date" => "required|date",
            "description" => "string|nullable"
        ]);
        $store_info['remain_qty'] = $store_info['qty'];
        $store_info['payable_amount'] = $store_info['remain_qty'] * $store_info['monthly_amount'];
        // dd($store_info);
        $store = new Store($store_info);
        $store->save();
        return redirect('/store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::where('id', $id)->first();
        // dd($store);
        $withdraw_infos = WithdrawInfo::where('store_id', $id)->orderBy('withdraw_date', 'desc')->get();
        
        return view('store.show', compact('store', 'withdraw_infos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = Store::select('id', 'name', 'remain_qty', 'block', 'floor')->where('id', $id)->first();
        return view('store.edit', compact('store'));
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
        $withdraw_info = request()->validate([
            "withdraw_qty" => "required|numeric",
            "withdraw_date" => "required|date"
        ]);
        $withdraw_info['store_id'] = $id;
        $withdraw_info['created_at'] = date('Y-m-d');
        // dd($withdraw_info);

        $store_update_info = request()->validate([
            "floor" => "required|integer|between:0,6",
            "block" => "required|string",
        ]);
        $store = Store::select('remain_qty')->where('id', $id)->first();
        $store_update_info['remain_qty'] = $store['remain_qty'] - $withdraw_info['withdraw_qty'];
        $store_update_info['updated_at'] = date('Y-m-d');
        // dd($store_update_info);

        $withdraw = new WithdrawInfo($withdraw_info);
        $withdraw->save();
        
        Store::where('id', $id)->update($store_update_info);
        return redirect('/store');

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
