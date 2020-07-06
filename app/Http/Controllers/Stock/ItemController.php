<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::all();
        // dd($customer);
        return view('item.index', compact('items'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        //validating data
        $data = request()->validate([
            'name' => 'required|unique:items',
            'sku' => 'required|string',
            'description' => 'string|nullable',
            'image' => 'string|nullable',
            'asset' => 'integer'
        ]);
        
        $item = new Item($data);
        $item->save();
        return redirect()->route('item.index');
    }

    public function show(Item $item)
    {
        //
    }

    public function edit(Item $item)
    {
        return view('item.edit',compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $data = request()->validate([
            'name' => 'required',
            'sku' => 'required|string',
            'description' => 'string|nullable',
            'image' => 'string|nullable',
            'asset' => 'integer'
        ]);
        $item->update($data);
        return redirect()->route('item.index')->with('success', 'Updated Successfully!');
    }

    public function destroy(Item $item)
    {
        //
    }
}
