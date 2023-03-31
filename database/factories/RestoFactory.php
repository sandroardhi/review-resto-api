<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resto>
 */
class RestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>  $this->faker->word(),
            'description' =>  $this->faker->sentence(200),
            'address' =>  $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
