<?php

use Illuminate\Database\Seeder;

use App\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::truncate();

        $customer = Customer::create([
            'name' => 'Customer',
            'address' => 'address',
            'mobileno' => '9999999999',
            'other' => '9999999999'
        ]);
    }
}
