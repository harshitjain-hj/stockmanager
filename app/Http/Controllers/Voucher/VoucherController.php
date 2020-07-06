<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Customer;
use App\Item;
use App\CustomerRepo;

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
        dd($request->all());
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
            $asset_data = $response['asset'];
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
            "asset_data" => $asset_data,
            "total_amount" => $response['total_amount'],
            "amount_recieved" => $response['amt_recieved'],
            "outstanding" => $outstanding,
            "remark" => $response['remark'],
        ];
        dd($data);
        return view('voucher.print_sale', compact('item_array', 'customer')); 
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
