<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		User::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'harshit@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
