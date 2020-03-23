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
        User::truncate();

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'harshit@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
