<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constant\Constant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'childs' => ['Lihat Rangkuman Penjualan', 'Lihat Produk Favorit', 'Lihat Stok Menipis', 'Filter Laporan'],
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
                'childs' => ['Lihat Peran', 'Tambah Peran', 'Ubah Peran']
            ],
            [
                'name' => 'Pengguna',
                'childs' => ['Lihat Pengguna', 'Tambah Pengguna', 'Ubah Pengguna', 'Ganti Password']
            ],
            [
                'name' => 'Produk',
                'childs' => ['Lihat Produk', 'Cari Produk', 'Tambah Produk', 'Ubah Produk', 'Konfigurasi Harga']
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
                'childs' => ['Lihat Pemasok', 'Tambah Pemasok', 'Ubah Pemasok']
            ],
            [
                'name' => 'Pemesanan Stok',
                'childs' => ['Lihat Pemesanan Stok', 'Tambah Pemesanan Stok', 'Ubah Pemesanan Stok', 'Batalkan Pemesanan', 'Cetak Pemesanan']
            ],
            [
                'name' => 'Penerimaan Stok',
                'childs' => ['Lihat Penerimaan Stok', 'Tambah Penerimaan Stok', 'Ubah Penerimaan Stok']
            ],
            [
                'name' => 'Pelanggan',
                'childs' => ['Lihat Pelanggaran', 'Tambah Pelanggan', 'Ubah Pelanggan', 'Cari Pelanggan'] 
            ],
            [
                'name' => 'Transaksi',
                'childs' => ['Lihat Transaksi', 'Tambah Transaksi', 'Ubah Transaksi', 'Lihat Rangkuman Transaksi Hari Ini', 'Filter Transaksi', 'Download Laporan']
            ],
            [
                'name' => 'Kasbon',
                'childs' => ['Tambah Kasbon', 'Lihat Kasbon', 'Ubah Kasbon', 'Cari Kasbon']
            ],
            [
                'name' => 'Laporan',
                'childs' => ['Lihat Laporan Stok Produk', 'Filter Laporan Stok Produk', 'Download Laporan Stok Produk', 'Lihat Aktifitas Stok Produk', 'Download Laporan Aktifitas Stok Produk', 'Filter Laporan Aktifitas Stok Produk',  'Lihat Laporan Akun', 'Filter Laporan Akun', 'Download Laporan Akun', 'Lihat Aktifitas Akun', 'Filter Aktifitas Akun', 'Download Aktifitas Akun']
            ],
            [
                'name' => 'Pembayaran Kasbon',
                'childs' => ['Lihat Pembayaran Kasbon', 'Tambah Pembayaran Kasbon', 'Ubah Pembayaran Kasbon']
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
		
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'testing@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);

        $user->createToken('API Token of ' . $user->name, ['api_access']);
	
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
