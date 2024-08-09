<?php

namespace Database\Seeders;

use App\Models\TransaksiH;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiHSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransaksiH::factory(100)->create();
    }
}
