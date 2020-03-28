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

class CustomerRepoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repos = CustomerRepo::all();
        // dd($repos);
        $customers = Customer::select('id', 'name')->get();
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
    public function show($id)
    {
        $customer = Customer::where('id', $id)->select('name')->first();
        $name = $customer['name'];
        // dd($name);
        $items = Item::select('id', 'name', 'sku')->get();
        $repo = CustomerRepo::where('customer_id', $id)->first();
        $sales = Sale::where('customer_id', $id)->get();
        // dd($sales);
        return view('report.show', compact('repo', 'name', 'items', 'sales'));
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
