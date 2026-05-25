<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessCode;
use Carbon\Carbon;

class AccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kode untuk Owner (sangat terbatas)
        AccessCode::create([
            'code' => 'OWNER2026',
            'description' => 'Kode akses khusus Owner - Hanya 1 orang',
            'for_role' => 'owner',
            'is_active' => true,
            'max_uses' => 1, // Cuma boleh 1 owner
            'current_uses' => 0,
            'expires_at' => null, // Tidak pernah expire
        ]);

        // Kode untuk Admin
        AccessCode::create([
            'code' => 'ADMIN2026',
            'description' => 'Kode akses Admin tahun 2026',
            'for_role' => 'admin',
            'is_active' => true,
            'max_uses' => 3, // Maksimal 10 admin
            'current_uses' => 0,
            'expires_at' => Carbon::now()->addYear(), // Expire 1 tahun
        ]);
    }
}