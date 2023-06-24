<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->administrator()->create();
        \App\Models\Unit::factory()
            ->count(5)
            ->sequence(
                ['name' => 'Rupiah', 'description' => 1],
                ['name' => 'Kilogram', 'description' => 2],
                ['name' => 'Gram', 'description' => 3],
                ['name' => 'Liter', 'description' => 4],
                ['name' => 'Ekor', 'description' => 5]
            )
            ->create();
    }
}
