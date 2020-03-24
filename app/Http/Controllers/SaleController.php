<?php

namespace App\Http\Controllers;

use App\Sale;
use App\CustomerRepo;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
        // dd($sales);
        return view('sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.create');
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
            'bill_no' => 'required|numeric|unique:sales',
            'customer_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'amount' => 'required|numeric',
            'bill_date' => 'required|date',
            'description' => 'string|nullable',
            'given_amount' => 'nullable|numeric',
            'given_crate' => 'nullable|numeric',
        ]);

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
                'remain_assets' => $saledata['qty'] - $saledata['given_crate'],
            ]);
            $repo = new CustomerRepo($repocreationdata);
            $repo->save();

        } else {

            CustomerRepo::where(['customer_id'=> $saledata['customer_id'], 'item_id' => $saledata['item_id']])->update([
                'total_amount' => $customer_repo['total_amount'] + $saledata['total_amount'],
                'remain_amount' => $customer_repo['remain_amount'] + $saledata['total_amount'] - $saledata['given_amount'],
                'remain_assets' => $customer_repo['remain_assets'] + $saledata['qty'] - $saledata['given_crate'],
            ]);
            
        }
        
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
