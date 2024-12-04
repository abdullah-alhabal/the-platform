<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Javed Ur Rehman',
            'email' => 'javed@allphptricks.com',
            'password' => Hash::make('javed1234'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'ahsan@allphptricks.com',
            'password' => Hash::make('ahsan1234'),
        ]);
        $admin->assignRole('Admin');

        $user = User::create([
            'name' => 'Naghman Ali',
            'email' => 'naghman@allphptricks.com',
            'password' => Hash::make('naghman1234'),
        ]);
        $user->assignRole('User');
    }
}
