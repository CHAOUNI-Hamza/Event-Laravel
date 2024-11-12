<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mobility>
 */
class MobilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name_benefit' => $this->faker->firstName,
            'last_name_benefit' => $this->faker->lastName,
            'date_go' => $this->faker->date,
            'date_return' => $this->faker->date,
            'destination' => $this->faker->country,
            'laboratory' => $this->faker->company,
            'department' => $this->faker->word,
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['encours', 'valider', 'novalider']),
            //'slug' => Str::slug($this->faker->sentence),
        ];
    }
}
