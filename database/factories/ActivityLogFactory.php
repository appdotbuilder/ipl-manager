<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = ['created', 'updated', 'deleted', 'imported', 'exported'];
        $entityTypes = ['IplPayment', 'Resident', 'Expense', 'DataSync'];
        
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement($actions),
            'entity_type' => $this->faker->randomElement($entityTypes),
            'entity_id' => $this->faker->numberBetween(1, 100),
            'old_values' => $this->faker->optional()->randomElement([
                ['name' => 'Old Value', 'amount' => 50000],
                ['status' => 'unpaid', 'notes' => 'Old notes'],
            ]),
            'new_values' => [
                'name' => $this->faker->name(),
                'amount' => $this->faker->numberBetween(50000, 100000),
                'status' => 'paid',
                'notes' => $this->faker->sentence(),
            ],
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}