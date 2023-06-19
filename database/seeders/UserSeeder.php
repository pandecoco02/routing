<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->email = 'superadmin@gmail.com';
        $user->password = bcrypt('*1234#');
        $user->first_name = 'super';
        $user->last_name = 'admin';
        $user->position = 'admin';
        $user->save();
        $user->roles()->sync([1]);
    }
}
