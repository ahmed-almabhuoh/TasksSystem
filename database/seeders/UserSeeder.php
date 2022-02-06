<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'id' => 1,
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'id' => 2,
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'id' => 3,
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('password')
        ]);


        User::create([
            'id' => 4,
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'id' => 5,
            'name' => 'user5',
            'email' => 'user5@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
