<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Pemasukan
        Category::create(['name' => 'Gaji', 'type' => 'pemasukan']);
        Category::create(['name' => 'Bonus', 'type' => 'pemasukan']);
        Category::create(['name' => 'Pendapatan Lain', 'type' => 'pemasukan']);

        // Kategori Pengeluaran
        Category::create(['name' => 'Makanan & Minuman', 'type' => 'pengeluaran']);
        Category::create(['name' => 'Transportasi', 'type' => 'pengeluaran']);
        Category::create(['name' => 'Tagihan', 'type' => 'pengeluaran']);
        Category::create(['name' => 'Belanja', 'type' => 'pengeluaran']);
        Category::create(['name' => 'Hiburan', 'type' => 'pengeluaran']);
    }
}