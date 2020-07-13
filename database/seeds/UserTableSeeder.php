<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        $customerRole = Role::where('name', 'customer')->first();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@employee.com',
            'password' => Hash::make('password')
        ]);
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@customer.com',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach($adminRole);
        $employee->roles()->attach($employeeRole);
        $customer->roles()->attach($customerRole);
    }
}
