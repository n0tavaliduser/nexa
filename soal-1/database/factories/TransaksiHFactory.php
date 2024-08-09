<?php

namespace Database\Factories;

use App\Models\MsCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiH>
 */
class TransaksiHFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('2024-01-01', 'now');

        return [
            'customer_id' => MsCustomer::pluck('id')->random(),
            'nomor_transaksi' => 'SO/' . $date->format('Y') . '-' . $date->format('m') . '/' . str_pad(fake()->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'tanggal_transaksi' => $date->format('Y-m-d'),
            'total_transaksi' => fake()->numberBetween(10000, 99999999),
        ];
    }
}
