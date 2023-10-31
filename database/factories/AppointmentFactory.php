<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_at = fake()->dateTimeBetween(startDate: '-6 months');
        $end_at = $start_at->add(new DateInterval("PT1H"));

        return [
            'title' => fake()->word(),
            'location' => fake()->word(),
            'status' => fake()->randomElement(['New', 'Attended', 'Cancelled']),
            'start_at' => $start_at,
            'end_at' => $end_at,
        ];
    }
}
