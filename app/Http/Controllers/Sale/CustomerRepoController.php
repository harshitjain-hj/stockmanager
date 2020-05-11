<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;

// Specific
use App\CustomerRepo;

// Helper
use App\Customer;
use App\Item;
use App\Sale;

use Illuminate\Http\Request;
use DB;

class CustomerRepoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repos =  DB::table('customer_repos')->join('customers', 'customer_repos.customer_id', 'customers.id')->orderBy('remain_amount', 'desc')->get(array('customer_repos.*', 'customers.name'));

        // $repos = CustomerRepo::orderBy('remain_amount', 'desc')->get();
        // dd($repos);
        $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $items = Item::select('id', 'name', 'sku')->get();
        return view('report.index', compact('repos', 'customers', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $char = '';
        $char = $request->character;
        if($char == 'bill') {
            $number = range(0, 400);
            $sales =  DB::table('sales')->where('customer_id', $id)->whereIn('bill_no', $number)->join('customers', 'sales.customer_id', 'customers.id')->orderByRaw('LENGTH(bill_no) desc')->orderBy('bill_no', 'desc')->get(array('sales.*', 'customers.name'));
        } else {
            $sales =  DB::table('sales')->where('customer_id', $id)->where('bill_no', 'LIKE', "%{$char}%")->join('customers', 'sales.customer_id', 'customers.id')->orderByRaw('LENGTH(bill_no) desc')->orderBy('bill_no', 'desc')->get(array('sales.*', 'customers.name'));
        }

        // $sales = DB::table('sales')->where('customer_id', $id)->join('customers', 'sales.customer_id', 'customers.id')->orderBy('id', 'desc')->get(array('sales.*', 'customers.name'));
        // dd($sales);
        $items = Item::select('id', 'name', 'sku')->get();
        $repo = CustomerRepo::where('customer_id', $id)->join('customers', 'customer_repos.customer_id', 'customers.id')->first();
        // dd($sales);
        // dd($repo);
        return view('report.show', compact('repo', 'items', 'sales'));
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
