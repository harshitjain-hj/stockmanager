<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Customer;
use App\Item;
use App\CustomerRepo;
use App\Voucher;
use App\Sale;

use DB;

class VoucherController extends Controller
{

	public function index()
    {
		$sales = Voucher::where('voucher_type', 'Sale')
							->select('vouchers.id as V.ID', 'customers.name', 'item_data as item','total_amount as total', 'asset_data as asset', 'amount_recieved as amt. recieved', 'remark')
							->join('customers', 'vouchers.customer_id', 'customers.id')
							->orderBy('vouchers.created_at', 'desc')
							->get();
		$recievings = Voucher::where('voucher_type', 'Recieve')
							->select('vouchers.id as V.ID', 'customers.name', 'asset_data as asset', 'amount_recieved as amt. recieved', 'remark')
							->join('customers', 'vouchers.customer_id', 'customers.id')
							->orderBy('vouchers.created_at', 'desc')
							->get();
		$unverified = Voucher::where('status', NULL)
							->select('vouchers.id as V.ID', 'customers.name', 'voucher_type', 'item_data as item','total_amount as total', 'asset_data as asset', 'amount_recieved as amt. recieved', 'remark')
							->join('customers', 'vouchers.customer_id', 'customers.id')
							->get();
		$bill_no = Sale::select('bill_no')
                    ->whereNotBetween('bill_no', array(1000,2000))
                    ->latest()
                    ->first();
        $sale_bill_no = "Sale";
        if(!empty($bill_no)){
            $sale_bill_no = preg_replace("/[^A-Za-z ]/", '', $bill_no['bill_no']) . (preg_replace("/[^0-9 ]/", '', $bill_no['bill_no'])+1);
        }
		$bill_no = Sale::select('bill_no')
                    ->whereBetween('bill_no', array(1000,2000))
                    ->latest()
                    ->first();
        $recieve_bill_no = "Recieve";
        if(!empty($bill_no)){
            $recieve_bill_no = preg_replace("/[^A-Za-z ]/", '', $bill_no['bill_no']) . (preg_replace("/[^0-9 ]/", '', $bill_no['bill_no'])+1);
        }
		$bill_no = [$sale_bill_no, $recieve_bill_no];
		return view('voucher.index', compact('sales', 'recievings', 'unverified', 'bill_no'));
    }

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
        $repo = CustomerRepo::where("customer_id", $id)->select("remain_amount", "remain_assets", "updated_at")->first();
		$outstanding = [
            "remain_amount" => $repo['remain_amount'],
            "remain_assets" => json_decode($repo['remain_assets']),
			"updated_at" => $repo['updated_at']->format('Y-m-d H:i:s')
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
		// dd($data);
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
        $repo = CustomerRepo::where("customer_id", $id)->select("remain_amount", "remain_assets", "updated_at")->first();
		$outstanding = [
            "remain_amount" => $repo['remain_amount'],
            "remain_assets" => json_decode($repo['remain_assets']),
			"updated_at" => $repo['updated_at']->format('Y-m-d H:i:s')
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
		// dd($data);
        $voucher = new Voucher($data);
        $voucher->save();

        return view('voucher.print_recieve', compact('customer', 'voucher', 'outstanding'));
    }

	public function verified(Request $request, $id)
	{
		$voucher_det = Voucher::where('id', $id)->first();
		$asset_det = json_decode($voucher_det['asset_data'], true);
		$bill = [
			'bill_no' => $request['bill_no'],
			'customer_id' => $voucher_det['customer_id'],
			'bill_date' => $voucher_det['created_at']->format('Y-m-d'),
			'given_amount' => $voucher_det['amount_recieved'],
			'description' => $voucher_det['remark'],
		];
		$bills = [];
		// for sale + recieve
		if ($voucher_det['item_data']) {
			foreach (json_decode($voucher_det['item_data'], true) as $key => $value) {
				$key = array_search(explode('#', $value['info'])[0], array_column($asset_det, 'id'));

				$bill['item_id'] = explode('#', $value['info'])[0];
				$bill['qty'] = $value['qty'];
				$bill['amount'] = $value['rate'];
				$bill['total_amount'] = $value['qty'] * $value['rate'];
				$bill['given_assets'] = ($key !== false) ? $asset_det[$key]['recieved'] : NULL;

				// print("<pre>".print_r($bill,true)."</pre>");
				array_push($bills, $bill);

				$bill['given_amount'] = NULL;
			}
		} // for cash + asset recieve
		elseif ($voucher_det['asset_data']) {
			foreach (json_decode($voucher_det['asset_data'], true) as $key => $value) {
				$bill['given_assets'] = $value['recieved'];

				// print("<pre>".print_r($bill,true)."</pre>");
				array_push($bills, $bill);

				$bill['given_amount'] = NULL;

			}
		} // for just cash
		else {
			// print("<pre>".print_r($bill,true)."</pre>");
			array_push($bills, $bill);
		}

		// dd($bills);


		foreach ($bills as $saledata) {
			$customer_repo = CustomerRepo::where('customer_id', $saledata['customer_id'])->select('total_amount', 'remain_amount', 'remain_assets')->first();

	        $asset_status = Item::where('id', $saledata['item_id'])->select('asset')->first();
			// dd($customer_repo);

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
		}

		return redirect()->route('voucherlist')->with('success', 'Updated!');
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
