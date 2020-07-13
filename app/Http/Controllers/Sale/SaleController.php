<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

// Specific
use App\Sale;
use App\CustomerRepo;

// Helper
use App\Customer;
use App\Item;
use App\Stock;
use DB;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $char = '';
        $sales = '';
        $char = $request->character;
        // if(DB::table('sales')->count()) {
            if($char == 'bill') {
                // $char = 'A';
                // $number = range(600,1000);
                // dd($number);
                $sales =  DB::table('sales')
                            // ->whereIn('bill_no', $number)
                            ->whereBetween('bill_no', array(1,2001))
                            ->join('customers', 'sales.customer_id', 'customers.id')
                            ->orderBy('bill_no', 'desc')
                            ->select(array('sales.*', 'customers.name'))->get();
                // dd($sales);
            } elseif ($request->path() == 'sale' && empty($char)) {
                // If viewing a particular diary
                $sales = DB::table('sales')
                        ->join('customers', 'sales.customer_id', 'customers.id')
                        ->orderBy('bill_no', 'desc')
                        ->where('bill_date', '>=', date('Y-m-d',strtotime("-2 days")))
                        ->get(array('sales.*', 'customers.name'));
            } 
            else {
                $sales = DB::table('sales')->where('bill_no', 'LIKE', "%{$char}%")->join('customers', 'sales.customer_id', 'customers.id')
                //->orderByRaw('LENGTH(bill_no) desc')
                ->orderBy('bill_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(array('sales.*', 'customers.name'));
                // dd($sales);
            }
        // }
        $items = Item::select('id', 'name', 'sku')->get();
        // dd($customers);
        return view('sale.index', compact('sales', 'items'));
    }

    public function create()
    {
        // $number = range(700, 998);
        $id = Sale::select('bill_no')
                    ->whereNotBetween('bill_no', array(1,2001))
                    // ->whereNotIn('bill_no', $number)
                    ->latest()
                    ->first();
        $bill_no = "Bill No";
        if(!empty($id)){
            $bill_no = preg_replace("/[^A-Za-z ]/", '', $id['bill_no']) . (preg_replace("/[^0-9 ]/", '', $id['bill_no'])+1);
        // dd($bill_no);
        }
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $items = Item::select('id', 'name')
                        ->whereNotBetween('id', [2, 5])
                        ->get();
        return view('sale.create', compact('bill_no', 'customers', 'items'));
    }

    public function receive()
    {   
        // $number = range(800, 1200);
        $id = Sale::select('bill_no')
                    // ->whereIn('bill_no', $number)
                    ->whereBetween('bill_no', array(1,2001))
                    ->orderBy('bill_no', 'desc')
                    ->first();
        $bill_no = "Bill No";
        if(!empty($id)){
            $bill_no = preg_replace("/[^A-Za-z ]/", '', $id['bill_no']) . (preg_replace("/[^0-9 ]/", '', $id['bill_no'])+1);
        // dd($bill_no);
        }
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $items = Item::select('id', 'name')
                        ->whereNotBetween('id', [2, 5])
                        ->where('asset', '1')
                        ->get();
        return view('sale.receive', compact('bill_no', 'customers', 'items'));
    }

    public function store(Request $request)
    {
        //validating data
        $saledata = request()->validate([
            'bill_no' => 'required|string',
            'customer_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'qty' => 'required_without_all:given_amount,given_assets|required_with:amount|nullable|numeric',
            'amount' => 'required_with:qty|nullable|numeric',
            'bill_date' => 'required|date',
            'description' => 'string|nullable',
            'given_amount' => 'required_with:given_assets|nullable|numeric',
            'given_assets' => 'required_with:given_amount|nullable|numeric',
        ]);
        $saledata['total_amount'] = (string)($saledata['qty'] * $saledata['amount']);

        $customer_repo = CustomerRepo::where('customer_id', $saledata['customer_id'])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        
        $asset_status = Item::where('id', $saledata['item_id'])->select('asset')->first();

        if(empty($customer_repo)) {
            if ($asset_status['asset'] == '1') {
                $remain_assets = json_encode([[
                    'asset_id' => $saledata['item_id'],
                    'asset_remain' => $saledata['qty'] - $saledata['given_assets']
                ]]);
            } else {
                $remain_assets = json_encode([]);
            }     
            $repocreationdata = ([
                'customer_id' => $saledata['customer_id'],
                'total_amount' => $saledata['total_amount'],
                'remain_amount' => $saledata['total_amount'] - $saledata['given_amount'],
                'remain_assets' => $remain_assets,
            ]);
            $repo = new CustomerRepo($repocreationdata);
            $repo->save();

        } else {
            if ($asset_status['asset'] == '1') {
                $asset_details = json_decode($customer_repo['remain_assets']);
                $key = array_search($saledata['item_id'], array_column($asset_details, 'asset_id'));
                if ($key !== false) {
                    $asset_details[$key]->asset_remain = $asset_details[$key]->asset_remain + $saledata['qty'] - $saledata['given_assets'];
                } else {
                    array_push($asset_details, ['asset_id' => $saledata['item_id'], 'asset_remain' => $saledata['qty'] - $saledata['given_assets']]);
                }
            } else {
                $asset_details = json_decode($customer_repo['remain_assets']);
            }
            // dd($asset_details);
            CustomerRepo::where('customer_id', $saledata['customer_id'])->update([
                'total_amount' => $customer_repo['total_amount'] + $saledata['total_amount'],
                'remain_amount' => $customer_repo['remain_amount'] + $saledata['total_amount'] - $saledata['given_amount'],
                'remain_assets' => json_encode($asset_details)
            ]);
        }
        
        $stock = Stock::where(['item_id'=> $saledata['item_id']])->select('unit_remain', 'updated_at')->first(); 

        Stock::where(['item_id'=> $saledata['item_id']])->update([
            'unit_remain' => $stock['unit_remain'] - $saledata['qty'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $sale = new Sale($saledata);
        $sale->save();
        return redirect()->route('sale.index');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $sale = DB::table('sales')->where('sales.id', $id)
            ->join('customers', 'sales.customer_id', 'customers.id')
            ->join('items', 'sales.item_id', 'items.id')
            ->get(array('sales.*', 'customers.name', 'items.name as item_name'));
        $sale = $sale['0']; 
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        // dd($sale);
        return view('sale.edit', compact('sale', 'customers'));
    }

    
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $saledata = request()->validate([
            'bill_no' => 'required|string',
            'customer_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'amount' => 'required|numeric',
            'bill_date' => 'required|date',
            'description' => 'string|nullable',
            'given_amount' => 'nullable|numeric',
            'given_assets' => 'nullable|numeric',
        ]);

        $saledata['total_amount'] = (string)($saledata['qty'] * $saledata['amount']);
        $sale_data_asset_status = Item::where('id', $saledata['item_id'])->select('asset')->first();
        
        $old_data = DB::table('sales')->where('id', $id)->first();
        $old_data_asset_status = Item::where('id', $old_data->item_id)->select('asset')->first();
        // dd($old_data);
        $old_customer_repo = CustomerRepo::where('customer_id', $old_data->customer_id)->select('total_amount', 'remain_amount', 'remain_assets')->first();
        
        if ($old_data_asset_status['asset'] == '1') {
            $old_asset_details = json_decode($old_customer_repo['remain_assets']);
            $key = array_search($old_data->item_id, array_column($old_asset_details, 'asset_id'));
            if ($key !== false) {
                $old_asset_details[$key]->asset_remain = $old_asset_details[$key]->asset_remain - $old_data->qty + $old_data->given_assets;
            }
        } else {
            $old_asset_details = json_decode($customer_repo['remain_assets']);
        }
        // for older entry sub
        CustomerRepo::where('customer_id', $old_data->customer_id)->update([
            'total_amount' => $old_customer_repo['total_amount'] - $old_data->total_amount,
            'remain_amount' => $old_customer_repo['remain_amount'] - $old_data->total_amount + $old_data->given_amount,
            'remain_assets' => json_encode($old_asset_details),
        ]);

        $new_customer_repo = CustomerRepo::where('customer_id', $saledata['customer_id'])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        // dd($new_customer_repo);

        if ($sale_data_asset_status['asset'] == '1') {
            $asset_details = json_decode($new_customer_repo['remain_assets']);
            $key = array_search($saledata['item_id'], array_column($asset_details, 'asset_id'));
            if ($key !== false) {
                $asset_details[$key]->asset_remain = $asset_details[$key]->asset_remain + $saledata['qty'] - $saledata['given_assets'];
            } else {
                array_push($asset_details, ['asset_id' => $saledata['item_id'], 'asset_remain' => $saledata['qty'] - $saledata['given_assets']]);
            }
        } else {
            $asset_details = json_decode($customer_repo['remain_assets']);
        }
        // for newer entry add
        CustomerRepo::where('customer_id', $saledata['customer_id'])->update([
            'total_amount' => $new_customer_repo['total_amount'] + $saledata['total_amount'],
            'remain_amount' => $new_customer_repo['remain_amount'] + $saledata['total_amount'] - $saledata['given_amount'],
            'remain_assets' => json_encode($asset_details)
        ]);
        
        Sale::where('id', $id)->update($saledata);

        $stock = Stock::where(['item_id'=> $saledata['item_id']])->select('unit_remain', 'updated_at')->first();
        Stock::where(['item_id'=> $saledata['item_id']])->update([
            'unit_remain' => $stock['unit_remain'] - $saledata['qty'] + $old_data->qty,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('sale.index');

    }

    public function destroy($id)
    {
        $del_sale = Sale::findOrFail($id);
        $del_sale_data_asset_status = Item::where('id', $del_sale->item_id)->select('asset')->first();


        // modify customer repo
        $customer_repo = CustomerRepo::where('customer_id', $del_sale->customer_id)->select('total_amount', 'remain_amount', 'remain_assets')->first();
        
        if ($del_sale_data_asset_status['asset'] == '1') {
            $asset_details = json_decode($customer_repo['remain_assets']);
            $key = array_search($del_sale->item_id, array_column($asset_details, 'asset_id'));
            if ($key !== false) {
                $asset_details[$key]->asset_remain = $asset_details[$key]->asset_remain - $del_sale->qty + $del_sale->given_assets;
            }
        } else {
            $asset_details = json_decode($customer_repo['remain_assets']);
        }
        CustomerRepo::where('customer_id', $del_sale->customer_id)->update([
            'total_amount' => $customer_repo['total_amount'] - $del_sale->total_amount,
            'remain_amount' => $customer_repo['remain_amount'] - $del_sale->total_amount + $del_sale->given_amount,
            'remain_assets' => json_encode($asset_details)
        ]);

        // modify stock
        $stock = Stock::where(['item_id'=> $del_sale['item_id']])->select('unit_remain', 'updated_at')->first();
        Stock::where(['item_id'=> $del_sale['item_id']])->update([
            'unit_remain' => $stock['unit_remain'] + $del_sale['qty'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //delete sale
        $del_sale->delete();
        return redirect('sale')->with('success', 'Deleted successfully!');
    }
}
