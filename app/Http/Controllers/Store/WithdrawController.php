<?php

namespace App\Http\Controllers\Store;

use App\Store;
use App\WithdrawInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WithdrawController extends Controller
{
   
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $store = WithdrawInfo::where('withdraw_infos.id', $id)
                    ->select('withdraw_infos.id', 'withdraw_infos.batch_id', 'withdraw_infos.store_id', 'stores.name', 'stores.item_name', 'stores.qty', 'stores.remain_qty','bill_no', 'withdraw_qty','withdraw_date', 'withdraw_infos.lorry_no', 'withdraw_infos.description')
                    ->join('stores', 'withdraw_infos.batch_id', 'stores.id')
                    ->orderBy('withdraw_date', 'desc')
                    ->first();
        // dd($store);
        return view('store.withdraw.edit', compact('id', 'store'));
    }

    
    public function update(Request $request, $id)
    {
        $withdraw_info = request()->validate([
            "batch_id" => "required|numeric",
            "store_id" => "required|numeric",
            "bill_no" => "required|string",
            "withdraw_qty" => "required|numeric|lte:remain_qty",
            "lorry_no" => "string|nullable|regex:/^[A-Z]{2}[ -][0-9]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/",
            "withdraw_date" => "required|date",
            "description" => "string|nullable"
        ]);
        // dd($withdraw_info);
        
        $store = Store::select('id', 'store_id','remain_qty')->where('id', $withdraw_info['batch_id'])->first();
        
        $old_withdraw = WithdrawInfo::where('id', $id)->select('id', 'withdraw_qty')->first();
        // dd($old_withdraw);

        $store_update_info['remain_qty'] = $store['remain_qty'] + $old_withdraw['withdraw_qty'] - $withdraw_info['withdraw_qty'];
        $store_update_info['updated_at'] = date('Y-m-d');

        $old_withdraw->update($withdraw_info);
        
        $store->update($store_update_info);

        return redirect('/store/'.$store->store_id)->with('success', 'Modified successfully!');    

    }

   
    public function destroy($id)
    {
        //
    }
}
