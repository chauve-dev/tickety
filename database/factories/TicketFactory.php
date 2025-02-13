<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
        'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
        'type' => $this->faker->randomElement(['bug', 'feature', 'support']),
        'assignee' => User::factory(),
        'reporter' => User::factory(),
        'project' => $this->faker->word,
    ];

    }
}
