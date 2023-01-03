<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Manufacturer;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model_name' => $this->faker->word(),
            'year' => $this->faker->numberBetween(2004, 2023),
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'manufacturer_id' => $this->faker->randomElement(Manufacturer::pluck('id'))
        ];
    }
}
