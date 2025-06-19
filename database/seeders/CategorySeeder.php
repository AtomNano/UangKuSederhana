<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
public function run()
{
    $categories = [
        // Pemasukan
        ['name' => 'Gaji', 'type' => 'pemasukan'],  // Ubah nama kategori agar konsisten
        ['name' => 'Bonus', 'type' => 'pemasukan'],
        ['name' => 'Lainnya', 'type' => 'pemasukan'],
        
        // Pengeluaran - Anggaran Tetap
        ['name' => 'Biaya Sekolah', 'type' => 'pengeluaran'],
        ['name' => 'Cicilan', 'type' => 'pengeluaran'],
        ['name' => 'Sewa/KPR', 'type' => 'pengeluaran'],
        
        // Pengeluaran - Lainnya
        ['name' => 'Makan & Minum', 'type' => 'pengeluaran'],
        ['name' => 'Transport', 'type' => 'pengeluaran'],
        ['name' => 'Belanja', 'type' => 'pengeluaran'],
        ['name' => 'Lainnya', 'type' => 'pengeluaran'],
        
    ];

    foreach ($categories as $category) {
        Category::create($category);
    }
}
}