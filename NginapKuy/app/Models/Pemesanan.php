<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Defaultnya 'pemesanans', jadi ini opsional.
     * @var string
     */
    protected $table = 'pemesanans';

    /**
     * Kunci primer model.
     * Defaultnya 'id', jadi ini opsional.
     * @var string
     */
    protected $primaryKey = 'id_pemesanan';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'kamar_id',
        'check_in_date',
        'check_out_date',
        'jumlah_tamu',
        'total_harga',
        'status_pemesanan',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in_date' => 'date', // Mengubah ke objek Carbon Date
        'check_out_date' => 'date', // Mengubah ke objek Carbon Date
        'total_harga' => 'decimal:2', // Pastikan format desimal
    ];

    /**
     * Definisikan relasi 'belongsTo' dengan model User.
     * Sebuah pemesanan 'milik' satu user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Sesuaikan 'id' jika primary key User bukan 'id'
    }

    /**
     * Definisikan relasi 'belongsTo' dengan model Kamar.
     * Sebuah pemesanan 'milik' satu kamar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id_kamar'); // Sesuaikan 'id_kamar' jika primary key Kamar bukan 'id_kamar'
    }
}