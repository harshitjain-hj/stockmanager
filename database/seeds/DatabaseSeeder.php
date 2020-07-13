<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(CustomersTableSeeder::class);
        // $this->call(ItemsTableSeeder::class);
        // $this->call(LorryInfoTableSeeder::class);
        // $this->call(SalesTableSeeder::class);
        // $this->call(CustomerReposTableSeeder::class);
    }
}
