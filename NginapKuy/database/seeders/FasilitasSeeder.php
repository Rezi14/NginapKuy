<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            [
                'nama_fasilitas' => 'Sarapan Pagi',
                'deskripsi' => 'Termasuk sarapan prasmanan untuk dua orang.',
                'biaya_tambahan' => 50000.00,
            ],
            [
                'nama_fasilitas' => 'Akses Kolam Renang Pribadi',
                'deskripsi' => 'Akses eksklusif ke kolam renang pribadi kamar.',
                'biaya_tambahan' => 100000.00,
            ],
            [
                'nama_fasilitas' => 'Layanan Spa',
                'deskripsi' => 'Manjakan diri Anda dengan pengalaman spa yang menenangkan dan menyegarkan. Nikmati pijatan relaksasi dan perawatan tubuh premium untuk memulihkan energi setelah seharian beraktivitas.',
                'biaya_tambahan' => 75000.00,
            ],
            [
                'nama_fasilitas' => 'Antar Jemput Bandara',
                'deskripsi' => 'Layanan antar jemput dari/ke bandara.',
                'biaya_tambahan' => 150000.00,
            ],
            [
                'nama_fasilitas' => 'Tambahan Tempat Tidur',
                'deskripsi' => 'Tambahan satu tempat tidur single di kamar.',
                'biaya_tambahan' => 30000.00,
            ],
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::firstOrCreate(
                ['nama_fasilitas' => $item['nama_fasilitas']],
                $item
            );
        }

        $this->command->info('Fasilitas telah berhasil di-seed!');
    }
}