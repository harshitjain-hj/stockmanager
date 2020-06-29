<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::select('id', 'name as Name', 'address as Address', 'mobileno as Mob no.', 'other as Other')->orderBy('name', 'asc')->get();
        // dd($customers);
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        //validating data
        $data = request()->validate([
            'name' => 'required|unique:customers',
            'address' => 'string|nullable',
            'mobileno' => 'required|regex:/[0-9]{10}/',
            'other' => 'nullable|regex:/[0-9]{10}/',
        ]);
        // dd($data);
        
        $customer = new Customer($data);
        $customer->save();
        return redirect()->route('customer.index');
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit($id)
    {
        $customer_info = Customer::select('id', 'name', 'address', 'mobileno', 'other')->where('id', $id)->firstOrFail();
        return view('customer.edit', compact('customer_info'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'string|nullable',
            'mobileno' => 'required|regex:/[0-9]{10}/',
            'other' => 'nullable|regex:/[0-9]{10}/',
        ]);
        $customer->update($data);
        return redirect()->route('customer.index')->with('success', 'Updated Successfully!');
    }

    public function destroy(Customer $customer)
    {
        //
    }
}
