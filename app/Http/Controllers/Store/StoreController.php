<?php

namespace App\Http\Controllers\Store;

use App\Store;
use App\WithdrawInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class StoreController extends Controller
{
    public function index()
    {
        $names = Store::selectRaw('store_id, name, item_name, floor, block, sum(remain_qty) as remain_qty, updated_at')
                        ->groupBy('store_id', 'name', 'item_name')
                        ->orderBy('name', 'ASC')
                        ->get()->groupBy('name');
        // dd($names);

        $table = Store::select('store_id', 'name', 'item_name', 'floor', 'block', 'qty as stored_qty', 'remain_qty', 'storage_date')
            ->where('remain_qty', '!=', 0)
            ->orderBy('floor', 'ASC')->orderBy('block', 'ASC')
            ->get();
        // dd($table);
        return view('store.index', compact('names', 'table'));
    }

    public function create()
    {
        return view('store.create');
    }

    public function create_more($store_id)
    {
        $store = Store::select('store_id', 'name', 'item_name', 'mobile_no', 'monthly_amount')->findOrFail($store_id);
        return view('store.create_more', compact('store', 'store_id'));
    }

    public function store(Request $request)
    {
        // dd(str_replace(url('/'), '', url()->previous()));
        // dd($request->all());
        $store_info = request()->validate([
            "store_id" => "nullable|numeric",
            "name" => "required|string",
            "item_name" => "required|string",
            "mobile_no" => "required|regex:/[0-9]{10}/",
            "qty" => "required|numeric",
            "monthly_amount" => "required|numeric",
            "floor" => "required|alpha",
            "block" => "required|string",
            "lorry_no" => "string|nullable|regex:/^[A-Z]{2}[ -][0-9]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/",
            "storage_date" => "required|date",
            "description" => "string|nullable"
        ]);
        $store_info['remain_qty'] = $store_info['qty'];
        $store_info['payable_amount'] = $store_info['remain_qty'] * $store_info['monthly_amount'];
        // dd($store_info);
        $store = new Store($store_info);
        $store->save();
        if (str_replace(url('/'), '', url()->previous()) == "/store/create") {
            $store->update(['store_id' => $store->id]);
        }
        // dd($store);
        return redirect('/store');
    }

    public function show($id)
    {
        $store = Store::selectRaw('store_id, name, item_name, mobile_no, sum(qty) as stored_qty, sum(remain_qty) as remain_qty, status')
                        ->where('store_id', $id)
                        ->groupBy('store_id', 'name', 'item_name', 'mobile_no')
                        ->first();

        // dd($store);
        $store_info = Store::select('id', 'qty', 'monthly_amount', 'floor', 'block', 'storage_date', 'lorry_no', 'remain_qty', 'payable_amount', 'status', 'description', 'updated_at')
                            ->where('store_id', $id)->get();
        // dd($store_info);
        $withdraw_infos = WithdrawInfo::where('withdraw_infos.store_id', $id)
                                    ->select('withdraw_infos.id', 'stores.floor', 'stores.block', 'bill_no', 'withdraw_qty','withdraw_date', 'withdraw_infos.lorry_no', 'withdraw_infos.description')
                                    ->join('stores', 'withdraw_infos.batch_id', 'stores.id')
                                    ->orderBy('withdraw_date', 'desc')
                                    ->get();
        // dd($withdraw_infos);
        return view('store.show', compact('store', 'store_info', 'withdraw_infos'));
    }

    public function withdraw($id)
    {
        $bill_no = withdrawInfo::select('bill_no')->orderBy('id', 'desc')->first();
        $bill_no = preg_replace("/[^A-Za-z ]/", '', $bill_no['bill_no']) . (preg_replace("/[^0-9 ]/", '', $bill_no['bill_no'])+1);
        // dd($bill_no);
        $store = Store::select('id', 'store_id', 'name', 'item_name','remain_qty', 'block', 'floor', 'storage_date')->findorFail($id);
        return view('store.withdraw', compact('id', 'store', 'bill_no'));
    }

    public function withdraw_update(Request $request)
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
        $withdraw_info['created_at'] = date('Y-m-d');
        // dd($withdraw_info);

        $store = Store::select('remain_qty')->where('id', $withdraw_info['batch_id'])->first();

        $store_update_info['remain_qty'] = $store['remain_qty'] - $withdraw_info['withdraw_qty'];
        $store_update_info['updated_at'] = date('Y-m-d');
        // dd($store_update_info);

        $withdraw = new WithdrawInfo($withdraw_info);
        // dd($withdraw->id);
        $withdraw->save();
        
        Store::where('id', $withdraw_info['batch_id'])->update($store_update_info);
        return redirect('/store');
    }

    public function edit($id)
    {
        $store = Store::select('id', 'name', 'remain_qty', 'block', 'floor')->where('id', $id)->first();
        return view('store.edit', compact('store'));
    }

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


    public function destroy($id)
    {
        //
    }
}
