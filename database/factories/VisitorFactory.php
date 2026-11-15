<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visitor_number' => fake()->unique()->bothify('V-####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'contact_number' => fake()->numerify('09#########'),
            'address' => fake()->address(),
            'purpose_of_visit' => fake()->sentence(),
            'person_to_visit' => fake()->name(),
            'department' => fake()->word(),
            'visit_date' => fake()->date(),
            'time_in' => fake()->time('H:i'),
            'time_out' => null,
            'status' => 'Checked In',
        ];
    }
}
