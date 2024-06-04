<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constant\Constant;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$roles = [
					'name' => 'Administrator',
					'status' => 1];
		
		$role = \App\Models\Roles::factory()->create(
			$roles
		);
		
		
        \App\Models\User::factory(1)->state(['role_id' => $role->id])->create();
    }
}
