<?php

use Illuminate\Database\Seeder;
use App\CustomerRepo;

class CustomerReposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerRepo::truncate();

        $repo = CustomerRepo::create([
            'customer_id' => '1',
            'item_id' => '1',
            'total_amount' => '400',
            'remain_amount' => '200',
            'remain_assets' => '1'
        ]);
    }
}
