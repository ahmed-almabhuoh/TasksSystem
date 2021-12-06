<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => 'Ahmad Almabhoh',
            'email' => 'a@tasks.com',
            'password' => Hash::make('password'),
            // 'email_verified_at' => null,
        ];
    }
}
