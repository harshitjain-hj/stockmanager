<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Customer;
use App\Item;
use App\CustomerRepo;
use App\Voucher;

use DB;

class VoucherController extends Controller
{
    
    public function customerList()
    {
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('voucher.customerList', compact('customers')); 
    }

    public function option($id)
    {
        return view('voucher.option', compact('id')); 
    }

    public function sale($id)
    {
        $customer = Customer::select('id', 'name')->findOrFail($id);
        $items = Item::select('id', 'name', 'sku', 'image', 'asset')->get();
        return view('voucher.sale', compact('items', 'customer')); 
    }

    public function recieve($id)
    {

        $customer = DB::table('customers')->select('customers.id', 'customers.name', 'remain_amount', 'remain_assets', 'customer_repos.updated_at')
                            ->where('customers.id', $id)
                            ->join('customer_repos', 'customers.id', 'customer_repos.customer_id')
                            ->first();
        
        $items = Item::select('id', 'name', 'sku','image')
                    ->where('asset', '1')
                    ->get();

        return view('voucher.recieve', compact('items', 'customer')); 
    }

    public function generatesale(Request $request, $id)
    {
        // dd($request->all());
        $customer = Customer::select('id', 'name')->findOrFail($id);
        $item_array = [];
        foreach ($request->all() as $ids => $info) {
            if($ids != '_token' && $info['qty'] !== NULL){
                array_push($item_array, $info);
            }
        }
        return view('voucher.review_sale', compact('item_array', 'customer')); 
    }

    public function printsale(Request $request, $id)
    {
        $customer = Customer::select('id', 'name')->findOrFail($id);
        $response = $request->all();
        $asset_data = [];
        if(isset($response['asset'])) {
            foreach ($response['asset'] as $ids => $info) {
                array_push($asset_data, $info);
            }
        }
        $repo = CustomerRepo::where("customer_id", $id)->select("remain_amount", "remain_assets")->first();
        $outstanding = [
            "remain_amount" => $repo['remain_amount']-$response['amt_recieved'],
            "remain_assets" => $repo['remain_assets']
        ];
        $data = [
            "voucher_type" => "Sale",
            "customer_id" => $id,
            "item_data" => $response['item_list'],
            "asset_data" => json_encode($asset_data),
            "total_amount" => $response['total_amount'],
            "amount_recieved" => $response['amt_recieved'],
            "outstanding" => json_encode($outstanding),
            "remark" => $response['remark'],
        ];
        $voucher = new Voucher($data);
        $voucher->save();

        return view('voucher.print_sale', compact('customer', 'voucher')); 
    }

    public function printrecieve(Request $request, $id)
    {
        $customer = Customer::select('id', 'name')->findOrFail($id);
        $response = $request->all();
        $item_array = [];
        if(isset($response['asset'])) {
            foreach ($response['asset'] as $ids => $info) {
                if($info['recieved'] !== NULL || $info['recieved'] != '0'){
                    array_push($item_array, $info);
                }
            }
        }
        $repo = CustomerRepo::where("customer_id", $id)->select("remain_amount", "remain_assets")->first();
        $outstanding = [
            "remain_amount" => $repo['remain_amount'] - $response['recieved_amount'],
            "remain_assets" => $repo['remain_assets']
        ];
        $data = [
            "voucher_type" => "Recieve",
            "customer_id" => $id,
            "item_data" => NULL,
            "asset_data" => json_encode($item_array),
            "total_amount" => NULL,
            "amount_recieved" => $response['recieved_amount'],
            "outstanding" => json_encode($outstanding),
            "remark" => $response['remark'],
        ];
        $voucher = new Voucher($data);
        $voucher->save();

        return view('voucher.print_recieve', compact('customer', 'voucher')); 
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
