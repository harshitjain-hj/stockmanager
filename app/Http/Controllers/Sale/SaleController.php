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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $char = '';
        $sales = '';
        $char = $request->character;
        if(DB::table('sales')->count()) {
            if($char == 'bill') {
                // $char = 'A';
                $number = range(0,400);
                // dd($number);
                $sales =  DB::table('sales')->whereIn('bill_no', $number)->join('customers', 'sales.customer_id', 'customers.id')->orderBy('bill_no', 'desc')->get(array('sales.*', 'customers.name'));
            } elseif ($request->path() == 'sale' && empty($char)) {
                $sales = DB::table('sales')
                        ->join('customers', 'sales.customer_id', 'customers.id')
                        ->orderBy('bill_no', 'desc')
                        ->where('bill_date', '>=', date('Y-m-d',strtotime("-2 days")))
                        ->get(array('sales.*', 'customers.name'));
            // dd($sales);
            } 
            else {
                $sales = DB::table('sales')->where('bill_no', 'LIKE', "%{$char}%")->join('customers', 'sales.customer_id', 'customers.id')
                //->orderByRaw('LENGTH(bill_no) desc')
                ->orderBy('bill_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(array('sales.*', 'customers.name'));
                // dd($sales);
            }
        }
        $items = Item::select('id', 'name', 'sku')->get();
        // dd($customers);
        return view('sale.index', compact('sales', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $number = range(0, 800);
        $id = Sale::select('bill_no')->whereNotIn('bill_no', $number)->latest()->first();
        $bill_no = "Bill No";
        if(!empty($id)){
            $bill_no = preg_replace("/[^A-Za-z ]/", '', $id['bill_no']) . (preg_replace("/[^0-9 ]/", '', $id['bill_no'])+1);
        // dd($bill_no);
        }
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $items = Item::select('id', 'name')->get();
        return view('sale.create', compact('bill_no', 'customers', 'items'));
    }
    public function receive()
    {   
        $number = range(0, 800);
        $id = Sale::select('bill_no')->whereIn('bill_no', $number)->orderBy('bill_no', 'desc')->first();
        $bill_no = "Bill No";
        if(!empty($id)){
            $bill_no = preg_replace("/[^A-Za-z ]/", '', $id['bill_no']) . (preg_replace("/[^0-9 ]/", '', $id['bill_no'])+1);
        // dd($bill_no);
        }
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $items = Item::select('id', 'name')->get();
        return view('sale.receive', compact('bill_no', 'customers', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        // dd($saledata);
        $saledata['total_amount'] = (string)($saledata['qty'] * $saledata['amount']);
        // dd($saledata);

        $customer_repo = CustomerRepo::where(['customer_id'=> $saledata['customer_id'], 'item_id' => $saledata['item_id']])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        // dd($customer_repo);
        
        if(empty($customer_repo)) {
            $repocreationdata = ([
                'customer_id' => $saledata['customer_id'],
                'item_id' => $saledata['item_id'],
                'total_amount' => $saledata['total_amount'],
                'remain_amount' => $saledata['total_amount'] - $saledata['given_amount'],
                'remain_assets' => $saledata['qty'] - $saledata['given_assets'],
            ]);
            $repo = new CustomerRepo($repocreationdata);
            $repo->save();

        } else {
            CustomerRepo::where(['customer_id'=> $saledata['customer_id'], 'item_id' => $saledata['item_id']])->update([
                'total_amount' => $customer_repo['total_amount'] + $saledata['total_amount'],
                'remain_amount' => $customer_repo['remain_amount'] + $saledata['total_amount'] - $saledata['given_amount'],
                'remain_assets' => $customer_repo['remain_assets'] + $saledata['qty'] - $saledata['given_assets'],
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        $old_data = DB::table('sales')->where('id', $id)->first();
        // dd($old_data);

        $old_customer_repo = CustomerRepo::where(['customer_id'=> $old_data->customer_id, 'item_id' => $old_data->item_id])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        // dd($old_customer_repo['total_amount']);

        // for older entry sub
        CustomerRepo::where(['customer_id'=> $old_data->customer_id, 'item_id' => $old_data->item_id])->update([
            'total_amount' => $old_customer_repo['total_amount'] - $old_data->total_amount,
            'remain_amount' => $old_customer_repo['remain_amount'] - $old_data->total_amount + $old_data->given_amount,
            'remain_assets' => $old_customer_repo['remain_assets'] - $old_data->qty + $old_data->given_assets,
        ]);

        $new_customer_repo = CustomerRepo::where(['customer_id'=> $saledata['customer_id'], 'item_id' => $saledata['item_id']])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        // dd($new_customer_repo);
        
        // for newer entry add
        CustomerRepo::where(['customer_id'=> $saledata['customer_id'], 'item_id' => $saledata['item_id']])->update([
            'total_amount' => $new_customer_repo['total_amount'] + $saledata['total_amount'],
            'remain_amount' => $new_customer_repo['remain_amount'] + $saledata['total_amount'] - $saledata['given_amount'],
            'remain_assets' => $new_customer_repo['remain_assets'] + $saledata['qty'] - $saledata['given_assets'],
        ]);
        
        Sale::where('id', $id)->update($saledata);

        $stock = Stock::where(['item_id'=> $saledata['item_id']])->select('unit_remain', 'updated_at')->first();
        Stock::where(['item_id'=> $saledata['item_id']])->update([
            'unit_remain' => $stock['unit_remain'] - $saledata['qty'] + $old_data->qty,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('sale.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del_sale = Sale::findOrFail($id);

        // modify stock
        $stock = Stock::where(['item_id'=> $del_sale['item_id']])->select('unit_remain', 'updated_at')->first();
        Stock::where(['item_id'=> $del_sale['item_id']])->update([
            'unit_remain' => $stock['unit_remain'] + $del_sale['qty'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // modify customer repo
        $customer_repo = CustomerRepo::where(['customer_id'=> $del_sale->customer_id, 'item_id' => $del_sale->item_id])->select('total_amount', 'remain_amount', 'remain_assets')->first();
        CustomerRepo::where(['customer_id'=> $del_sale->customer_id, 'item_id' => $del_sale->item_id])->update([
            'total_amount' => $customer_repo['total_amount'] - $del_sale->total_amount,
            'remain_amount' => $customer_repo['remain_amount'] - $del_sale->total_amount + $del_sale->given_amount,
            'remain_assets' => $customer_repo['remain_assets'] - $del_sale->qty + $del_sale->given_assets,
        ]);

        //delete sale
        $del_sale->delete();
        return redirect('sale')->with('success', 'Deleted successfully!');
    }
}
