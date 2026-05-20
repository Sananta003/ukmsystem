<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ukm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Super Admin (Pihak Kampus)
        User::create([
            'name' => 'Kemahasiswaan Kampus',
            'email' => 'superadmin@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'ukm_id' => null // Tidak terikat UKM
        ]);

        // 2. Buat 3 Sampel UKM
        $ukm1 = Ukm::create(['nama_ukm' => 'UKM Robotika', 'deskripsi' => 'Riset dan pengembangan teknologi robotika kampus.']);
        $ukm2 = Ukm::create(['nama_ukm' => 'UKM Paduan Suara', 'deskripsi' => 'Seni vokal dan paduan suara tingkat nasional.']);
        $ukm3 = Ukm::create(['nama_ukm' => 'UKM Futsal', 'deskripsi' => 'Wadah olahraga bola sepak dalam ruangan.']);

        // 3. Buat Akun Ketua (Admin) untuk masing-masing UKM
        User::create([
            'name' => 'Ketua Robotika',
            'email' => 'admin@robotika.com',
            'password' => Hash::make('password'),
            'role' => 'admin_ukm',
            'ukm_id' => $ukm1->id
        ]);

        User::create([
            'name' => 'Ketua Padus',
            'email' => 'admin@padus.com',
            'password' => Hash::make('password'),
            'role' => 'admin_ukm',
            'ukm_id' => $ukm2->id
        ]);

        // 4. Buat Akun BEM & BPM
        User::create([
            'name' => 'BEM Kampus',
            'email' => 'bem@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'bem',
        ]);

        User::create([
            'name' => 'BPM Kampus',
            'email' => 'bpm@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'bpm',
        ]);

        // 5. Buat Akun Member (Inisiator)
        User::create([
            'name' => 'Mahasiswa Inisiator',
            'email' => 'member@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}