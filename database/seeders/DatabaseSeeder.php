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
		$permissions = [
			[
				'name' => 'Lihat Dashboard',
				'url' => 'admin',
				'alias' => 'view_dashboard',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Lihat banner',
				'url' => 'heroes.index',
				'alias' => 'view_banner',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat banner',
				'url' => 'heroes.create.form',
				'alias' => 'create_banner',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update banner',
				'url' => 'heroes.update.form',
				'alias' => 'update_banner',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Urutkan banner',
				'url' => 'heroes.update.form',
				'alias' => 'order_banner',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Lihat buletin',
				'url' => 'post.index',
				'alias' => 'view_post',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat buletin',
				'url' => 'post.create.form',
				'alias' => 'create_post',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update buletin',
				'url' => 'post.update.form',
				'alias' => 'update_post',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Lihat struktur organisasi',
				'url' => 'structure.index',
				'alias' => 'view_structure',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat struktur organisasi',
				'url' => 'structure.create.form',
				'alias' => 'create_structure',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update struktur organisasi',
				'url' => 'structure.update.form',
				'alias' => 'update_structure',
				'icon' => 'example.svg',
			],

			[
				'name' => 'Lihat jenis kegiatan',
				'url' => 'activity.type.index',
				'alias' => 'view_activity',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat jenis kegiatan',
				'url' => 'activity.type.create.form',
				'alias' => 'create_activity',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update jenis kegiatan',
				'url' => 'activity.type.update.form',
				'alias' => 'update_activity',
				'icon' => 'example.svg',
			],
			
			[
				'name' => 'Atur jadwal kegiatan',
				'url' => 'activity.schedule.index',
				'alias' => 'manage_schedule',
				'icon' => 'example.svg',
			],

			[
				'name' => 'Lihat jenis transaksi',
				'url' => 'transaction.type.index',
				'alias' => 'view_transaction_type',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat jenis transaksi',
				'url' => 'transaction.type.create.form',
				'alias' => 'create_transaction_type',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update jenis transaksi',
				'url' => 'transaction.type.update.form',
				'alias' => 'update_transaction_type',
				'icon' => 'example.svg',
			],

			[
				'name' => 'Lihat jenis pembayaran',
				'url' => 'payment.index',
				'alias' => 'view_payment',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Buat jenis pembayaran',
				'url' => 'payment.create.form',
				'alias' => 'create_payment',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Update jenis pembayaran',
				'url' => 'payment.update.form',
				'alias' => 'update_payment',
				'icon' => 'example.svg',
			],
			[
				'name' => 'Lihat transaksi',
				'url' => 'transaction.index',
				'alias' => 'view_transaction',
				'icon' => 'example.svg',
			],
		];
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
		$roles = [
			[
				'name' => 'Administrator',
				'permission' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22',
				'status' => 1,
			],
		];
		foreach ($permissions as $permission)
		{
			\App\Models\Permission::factory()->create(
				$permission
			);
		}

		foreach ($roles as $role)
		{
			\App\Models\Roles::factory()->create(
				$role
			);
		}
		
		
        \App\Models\User::factory(10)->administrator()->create();
    }
}
