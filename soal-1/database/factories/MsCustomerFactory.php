<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCustomer>
 */
class MsCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name('id_ID'),
            'alamat' => $this->faker->address('id_ID'),
            'phone' => $this->faker->phoneNumber('id_ID'),
        ];
    }
}
