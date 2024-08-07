<?php

namespace Database\Seeders;

use App\Models\MsCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MsCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MsCustomer::factory(20)->create();
    }
}
