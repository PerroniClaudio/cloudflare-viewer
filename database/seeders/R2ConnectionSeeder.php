<?php

namespace Database\Seeders;

use App\Models\R2Connection;
use Illuminate\Database\Seeder;

class R2ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        R2Connection::factory()->count(3)->create();
    }
}
