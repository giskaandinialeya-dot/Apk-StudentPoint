<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder order: Users → Kelas → Siswas/Orang Tua → Others
        $this->call([
            UserSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            JenisPelanggaranSeeder::class,
        ]);
    }
}
