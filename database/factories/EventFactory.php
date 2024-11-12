<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'duration' => $this->faker->numberBetween(1, 10),
            'place' => $this->faker->randomElement(['amphie-fatima-mernissi', 'amphie-fatima-fihriya', 'amphie-imame-malik', 'amphie-youssi', 'autre']),
            'coordinator' => $this->faker->name,
            'laboratory' => $this->faker->company,
            'department' => $this->faker->jobTitle,
            'type' => $this->faker->randomElement(['scientifique', 'culturelle', 'autre']),
            'status' => $this->faker->randomElement(['encours', 'valider', 'novalider']),
            'user_id' => User::factory(),
            //'slug' => Str::slug($this->faker->sentence),
        ];
    }
}
