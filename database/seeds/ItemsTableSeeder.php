<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::truncate();

        $item = Item::create([
            'name' => 'Item Name',
            'sku' => 'SKU',
            'description' => 'Item description',
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTyvihCe1YijClj2E0GH8QCK-nByys1d_z2BdTOrZpaHvnAzK7Y'
        ]);
    }
}
