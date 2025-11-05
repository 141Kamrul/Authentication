<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataTable>
 */
class DataTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'office' => $this->faker->city,
            'age' => $this->faker->numberBetween(18, 65),
            'start_date' => $this->faker->dateTimeThisDecade,
            'salary' => $this->faker->numberBetween(15000, 200000),
            //
        ];
    }
}
