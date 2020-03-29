<?php

use Illuminate\Database\Seeder;
use App\LorryInfo;

class LorryInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LorryInfo::truncate();

        $lorry_info = LorryInfo::create([
            "item_id" => "1",
            "total_weight" => "10000",
            "arrived_unit" => "300",
            "created_unit" => "500",
            "purchase_cost" => "36000",
            "labour_cost" => "800",
            "lorry_cost" => "20000",
            "lorry_no" => "MP 18 3424",
            "unit_returned" => "300"
        ]);
    }
}
