<?php

namespace Database\Factories;

use App\Models\College;
use App\Models\Registration;
use App\Models\Section;
use App\Models\TShirtSize;
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

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'college_id' => fake()->randomElement(College::pluck('id')),
            'section_id' => fake()->randomElement(Section::pluck('id')),
            't_shirt_size_id' => fake()->randomElement(TShirtSize::pluck('id')),
            'nickname' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
