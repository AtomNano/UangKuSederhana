<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Kategori global (array asosiatif)
        $categories = [
            ['name' => 'Gaji', 'type' => 'pemasukan'],
            ['name' => 'Bonus', 'type' => 'pemasukan'],
            ['name' => 'Lainnya', 'type' => 'pemasukan'],
            ['name' => 'Biaya Sekolah', 'type' => 'pengeluaran'],
            ['name' => 'Cicilan', 'type' => 'pengeluaran'],
            ['name' => 'Sewa/KPR', 'type' => 'pengeluaran'],
            ['name' => 'Makan & Minum', 'type' => 'pengeluaran'],
            ['name' => 'Transport', 'type' => 'pengeluaran'],
            ['name' => 'Belanja', 'type' => 'pengeluaran'],
            ['name' => 'Lainnya', 'type' => 'pengeluaran'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate($cat);
        }

        // Buat User Dummy 1
        $user1 = User::create([
            'name' => 'Budi Sanjaya',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->createTransactionsForUser($user1);

        // Buat User Dummy 2
        $user2 = User::create([
            'name' => 'Ani Lestari',
            'email' => 'ani@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->createTransactionsForUser($user2);
    }

    private function createTransactionsForUser(User $user)
    {
        $pemasukanCat = Category::where('name', 'Gaji')->first();
        $pengeluaranCats = Category::where('type', 'pengeluaran')->get();

        // Gaji bulanan
        Transaction::create([
            'user_id' => $user->id,
            'category_id' => $pemasukanCat->id,
            'amount' => 5000000,
            'description' => 'Gaji bulanan',
            'transaction_date' => now()->startOfMonth(),
        ]);

        // Pengeluaran acak
        for ($i = 0; $i < 5; $i++) {
            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $pengeluaranCats->random()->id,
                'amount' => rand(25000, 200000),
                'description' => 'Pengeluaran ' . ($i + 1),
                'transaction_date' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}