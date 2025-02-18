<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::create([
            'uid' => uniqid(), // Generate a unique ID
            'fullname' => 'Mr. Admin',
            'nric_number' => '11111111',
            'password' => Hash::make('12345'), // Hash the password
            'email' => 'admin@gmail.com',
            'mobile_number' => '+601117387876',
            'user_group' => 'Admin',
            'district_access' => 'ALL',
            'profile_img' => null, // Nullable field
            'position' => null, // Add null if position is not specified
            'department' => null, // Add null if department is not specified
            'status' => 1, // Set status as active (1)
            'isdelete' => 0, // Ensure it's not deleted
        ]);
    }
}
