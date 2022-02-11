<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
            'name' => $this->faker->name(),
            'activated' => true,
            'value' => '3'
        ];
    }
}
