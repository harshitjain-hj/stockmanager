<?php

use Illuminate\Database\Seeder;
use App\Sale;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::truncate();

        $sale = Sale::create([
            'bill_no' => '101',
            'customer_id' => '1',
            'item_id' => '1',
            'qty' => '2',
            'amount' => '200',
            'total_amount' => '400',
            'given_amount' => '200',
            'given_assets' => '1',
            'bill_date' => date("Y-m-d"),
            'description' => 'Description about bill',
        ]);
    }
}
