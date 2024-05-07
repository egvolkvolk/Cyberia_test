<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->withFaker()->firstName() . rand(1, 1000);
        $role = 1;
        $balance = NULL;
        if (mt_rand(1, 100) > 15)
        {
            $role = 2;
            $balance = mt_rand(1000, 100000) * 10;
        };

        return [
            'name' => $name,
            'email' => $this->withFaker()->unique()->safeEmail(),
            'password' => Hash::make('11111'),
            'role_id' => $role,
            'balance' => $balance,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
