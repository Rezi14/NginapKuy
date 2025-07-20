<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipeKamar;

class TipeKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipeKamars = [
            [
                'nama_tipe_kamar' => 'Standard',
                'harga_per_malam' => 250000.00,
                'deskripsi' => 'Kamar standar dengan fasilitas dasar, cocok untuk budget traveler.',
                'foto_url' => 'img/standard.jpg', // <<< UBAH PATH FOTO, RELATIF DARI FOLDER PUBLIC
            ],
            [
                'nama_tipe_kamar' => 'Deluxe',
                'harga_per_malam' => 450000.00,
                'deskripsi' => 'Kamar lebih luas dengan fasilitas lengkap dan pemandangan kota.',
                'foto_url' => 'img/deluxe.jpg', // <<< UBAH PATH FOTO
            ],
            [
                'nama_tipe_kamar' => 'Suite',
                'harga_per_malam' => 800000.00,
                'deskripsi' => 'Kamar mewah dengan area lounge terpisah, bathtub, dan layanan premium.',
                'foto_url' => 'img/suite.jpg', // <<< UBAH PATH FOTO
            ],
            [
                'nama_tipe_kamar' => 'Family Room',
                'harga_per_malam' => 600000.00,
                'deskripsi' => 'Kamar luas dengan dua tempat tidur, cocok untuk keluarga.',
                'foto_url' => 'img/family.jpg', // <<< UBAH PATH FOTO
            ],
        ];

        foreach ($tipeKamars as $tipeKamar) {
            TipeKamar::firstOrCreate(
                ['nama_tipe_kamar' => $tipeKamar['nama_tipe_kamar']],
                $tipeKamar
            );
        }

        $this->command->info('Tipe Kamar telah berhasil di-seed (dengan foto)!');
    }
}