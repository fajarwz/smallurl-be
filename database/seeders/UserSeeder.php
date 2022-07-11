<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => config('app.guest_id'),
            'name' => 'Guest',
        ]);

        User::create([
            'id' => config('app.guest_id') + 1,
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('useruser1'),
        ]);
    }
}
