<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::insert([
        [
            'name' => 'Admin',
            'email' => 'admin@kambing.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ],
        [
            'name' => 'Pimpinan',
            'email' => 'pimpinan@kambing.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]
        ]);
    }
}
