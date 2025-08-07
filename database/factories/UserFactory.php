<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static $presetUsers = [
        ['name' => 'Sintia', 'email' => 'sintia@getnada.com', 'role' => 'pelanggan'],
        ['name' => 'Faiz', 'email' => 'faiz@getnada.com', 'role' => 'kasir'],
        ['name' => 'Aan', 'email' => 'aan@getnada.com', 'role' => 'admin'],
    ];

    protected static $index = 0;

    public function definition()
    {
        $i = static::$index++;

        if (!isset(static::$presetUsers[$i])) {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'role' => 'pelanggan',
                'email_verified_at' => now(),
                'password' => Hash::make('Password123!'),
                'remember_token' => Str::random(10),
            ];
        }

        return [
            'name' => static::$presetUsers[$i]['name'],
            'email' => static::$presetUsers[$i]['email'],
            'role' => static::$presetUsers[$i]['role'],
            'email_verified_at' => now(),
            'password' => Hash::make('Password123!'),
            'remember_token' => Str::random(10),
        ];
    }
}
