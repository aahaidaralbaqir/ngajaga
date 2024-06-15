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
                'childs' => ['Lihat Kas', 'Tambah Kas', 'Ubah Kas', 'Lihat Cashflow Account'],
            ],
            [
                'name' => 'Hak Akses',
                'childs' => ['Lihat Hak Akses', 'Tambah Hak Akses', 'Ubah Hak Akses']
            ],
            [
                'name' => 'Peran',
                'childs' => ['Lihat Peran', 'Tambah Peran', 'Ubah Peran']
            ],
            [
                'name' => 'Pengguna',
                'childs' => ['Lihat Pengguna', 'Tambah Pengguna', 'Ubah Pengguna']
            ],
            [
                'name' => 'Produk',
                'childs' => ['Lihat Produk', 'Tambah Produk', 'Ubah Produk']
            ],
            [
                'name' => 'Kategori',
                'childs' => ['Lihat Kategori', 'Tambah Kategori', 'Ubah Kategori']
            ],
            [
                'name' => 'Rak',
                'childs' => ['Lihat Rak', 'Tambah Rak', 'Ubah Rak']
            ],
            [
                'name' => 'Pemasok',
                'childs' => ['Lihat Pemasok', 'Tambab Pemasok', 'Ubah Pemasok']
            ],
            [
                'name' => 'Pemesanan Stok',
                'childs' => ['Lihat Pemesanan Stok', 'Tambah Pemesanan Stok', 'Ubah Pemesanan Stok', 'Hapus Pemesanan Stok']
            ],
            [
                'name' => 'Penerimaan Stok',
                'childs' => ['Lihat Penerimaan Stok', 'Tambah Penerimaan Stok', 'Ubah Penerimaan Stok', 'Hapus Penerimaan Stok']
            ],
            [
                'name' => 'Pelanggan',
                'childs' => ['Lihat Pelanggaran', 'Tambah Pelanggan', 'Ubah Pelanggan'] 
            ],
            [
                'name' => 'Transaksi',
                'childs' => ['Lihat Transaksi', 'Tambah Transaksi', 'Ubah Transaksi']
            ],
            [
                'name' => 'Laporan',
                'childs' => ['Lihat Laporan Transaksi', 'Lihat Laporan Keuangan']
            ]
        ];
        
        $permission_ids = [];
        foreach ($permission as $pp) {
            $parent_id = DB::table('permission')->insertGetId(['name' => $pp['name'], 'is_default' => Constant::OPTION_TRUE]);
            $permission_ids[] = $parent_id;
            if (array_key_exists('childs', $pp)) {
                foreach ($pp['childs'] as $kk) {
                   $permission_ids[] = DB::table('permission')->insertGetId(['name' => $kk, 'id_parent' => $parent_id, 'is_default' => Constant::OPTION_TRUE]);
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
