<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constant\Constant;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cashflows')->truncate();
		DB::table('users')->truncate();
		DB::table('roles')->truncate();
		DB::table('permission')->truncate();
		
        $permission = [
            [
                'name' => 'Dashboard',
                'childs' => ['Lihat Rangkuman Penjualan', 'Lihat Grafik Penjualan'],
            ],
            [
                'name' => 'Buku Kas',
                'childs' => ['Lihat Kas', 'Tambah Kas', 'Ubah Kas'],
            ],
            [
                'name' => 'Hak Akses',
                'childs' => ['Lihat Hak Akses', 'Tambah Hak Akses', 'Ubah Hak Akses']
            ],
            [
                'name' => 'Peran',
                'childs' => ['Lihat Peran', 'Tambah Peran', 'Ubah Peran', 'Hapus Peran']
            ],
            [
                'name' => 'Pengguna',
                'childs' => ['Tambah Pengguna', 'Hapus Pengguna', 'Ubah Pengguna']
            ],
            [
                'name' => 'Produk',
                'childs' => ['Tambah Produk', 'Ubah Produk', 'Hapus Produk']
            ],
            [
                'name' => 'Kategori',
                'childs' => ['Tambah Kategori', 'Ubah Kategori', 'Hapus Kategori']
            ],
            [
                'name' => 'Rak',
                'childs' => ['Tambah Rak', 'Ubah Rak', 'Hapus Rak']
            ],
            [
                'name' => 'Pemasok',
                'childs' => ['Tambab Pemasok', 'Ubah Pemasok', 'Hapus Pemasok']
            ],
            [
                'name' => 'Pemesanan Stok',
                'childs' => ['Tambah Pemesanan Stok', 'Ubah Pemesanan Stok', 'Hapus Pemesanan Stok']
            ],
            [
                'name' => 'Penerimaan Stok',
                'childs' => ['Tambah Penerimaan Stok', 'Ubah Penerimaan Stok', 'Hapus Penerimaan Stok']
            ],
            [
                'name' => 'Pelanggan',
                'childs' => ['Tambah Pelanggan', 'Ubah Pelanggan', 'Hapus Pelanggan'] 
            ],
            [
                'name' => 'Transaksi',
                'childs' => ['Tambah Transaksi', 'Ubah Transaksi']
            ],
            [
                'name' => 'Laporan',
                'childs' => ['Lihat Laporan Transaksi', 'Lihat Laporan Keuangan']
            ]
        ];
        
        $permission_ids = [];
        foreach ($permission as $pp) {
            $parent_id = DB::table('permission')->insertGetId(['name' => $pp['name']]);
            $permission_ids[] = $parent_id;
            if (array_key_exists('childs', $pp)) {
                foreach ($pp['childs'] as $kk) {
                   $permission_ids[] = DB::table('permission')->insertGetId(['name' => $kk, 'id_parent' => $parent_id]);
                }
            }
        }
        $roles = [
            'name' => 'Administrator',
            'permission' => implode(',', $permission_ids),
            'status' => Constant::STATUS_ACTIVE];
		$role = \App\Models\Roles::factory()->create(
			$roles
		);
		
		
        \App\Models\User::factory(1)->state(['role_id' => $role->id])->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
