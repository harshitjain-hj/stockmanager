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
    public function index(Request $request)
    {
        $repos =  DB::table('customer_repos')
                        ->join('customers', 'customer_repos.customer_id', 'customers.id')
                        ->orderBy('remain_amount', 'desc')
                        ->get(array('customer_repos.*', 'customers.name'));
        $items = Item::select('id', 'name', 'sku')->where('asset', '1')->get();
        return view('report.index', compact('repos', 'items'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id, Request $request)
    {
        $items = Item::select('id', 'name', 'sku')->get();
        $repo = CustomerRepo::where('customer_repos.id', $id)->join('customers', 'customer_repos.customer_id', 'customers.id')->first(array('customer_repos.*', 'customers.name'));
        // dd($repo);
        $char = '';
        $char = $request->character;
        if($char == 'bill') {
            // $number = range(0, 800);
            $sales =  DB::table('sales')
                        ->where('customer_id', $repo->customer_id)
                        // ->whereIn('bill_no', $number)
                        ->whereBetween('bill_no', array(1000,1500))
                        ->join('customers', 'sales.customer_id', 'customers.id')
                        ->orderBy('bill_no', 'desc')
                        ->get(array('sales.*', 'customers.name'));
        } elseif (!empty($char)) {
            $sales =  DB::table('sales')->where('customer_id', $repo->customer_id)->where('bill_no', 'LIKE', "%{$char}%")->join('customers', 'sales.customer_id', 'customers.id')->orderBy('bill_no', 'desc')->get(array('sales.*', 'customers.name'));
        } else {
            // variables
            // $number = range(0, 990);
            $amount = 0;
            $pending = [];
            $sales = DB::table('sales')->where('customer_id', $repo->customer_id)
                // ->whereNotIn('bill_no', $number)
                ->whereNotBetween('bill_no', array(1,2001))
                ->join('customers', 'sales.customer_id', 'customers.id')
                ->orderBy('bill_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(array('sales.*', 'customers.name'));
                foreach($sales as $sale) {
                    if ($amount < $repo->remain_amount) {
                        $amount = $amount + $sale->total_amount;
                        array_push($pending, $sale);
                    } else {
                        break;
                    }
                }
                $sales = json_encode($pending);
            // dd($sales);
        }


        return view('report.show', compact('repo', 'items', 'sales'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $repo = request()->validate([
            'remain_amount' => 'required|numeric',
        ]);
        $asset_array = [];
        if (isset($request['asset'])) {
            foreach($request['asset'] as $asset){
                array_push($asset_array, $asset);
            }
        }

        // dd(CustomerRepo::where('id', $id)->first());
        CustomerRepo::where('id', $id)->update([
            'remain_amount' => $repo['remain_amount'],
            'remain_assets' => json_encode($asset_array),
        ]);
        return redirect()->route('repo.show', $id)->with('success', 'Updated successfully!');
    }

    public function destroy($id)
    {
        //
    }

    // public function rectify(Request $request) {
    //     $persons =  DB::table('customer_repos')
    //                     ->join('customers', 'customer_repos.customer_id', 'customers.id')
    //                     ->groupBy('customer_id')
    //                     ->get(array('customer_repos.*', 'customers.name'));

    //     foreach($persons as $person) {
    //         echo $person->customer_id;
    //         $repos  = DB::table('customer_repos')
    //         ->orderBy('item_id', 'asc')
    //         ->orderBy('id', 'asc')
    //         ->where('customer_id', $person->customer_id)
    //         ->get();
    //         // dd($repos);
    //         $total_amount = 0;
    //         $remain_amount = 0;
    //         foreach($repos as $repo) {
    //             $total_amount = $total_amount + $repo->total_amount;
    //             $remain_amount = $remain_amount + $repo->remain_amount;
    //         }
    //         if($repos[0]->item_id == '1') {
    //             $remain_assets = json_encode([[
    //                 'asset_id' => '1',
    //                 'asset_remain' => $repos[0]->remain_assets
    //             ]]);
    //         } else {
    //             $remain_assets = json_encode([]);
    //         }
    //         // update the first repo
    //         DB::table('customer_repos')->where('id', $repos[0]->id)->update([
    //             'item_id' => "1",
    //             'total_amount' => $total_amount,
    //             'remain_amount' => $remain_amount,
    //             'remain_assets' => $remain_assets,
    //         ]);

    //         // deleting the rest report if any
    //         for ($i=1; $i<count($repos) ; $i++) {
    //             DB::table('customer_repos')->where('id', $repos[$i]->id)->delete();
    //         }
    //         echo "done";
    //     }
    //     echo "Completed";
    // }
}
