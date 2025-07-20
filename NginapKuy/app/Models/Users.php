<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Opsional, jika Anda ingin fitur verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah versi plural dari nama model (misal: 'users' untuk 'User').
     * Jika nama tabel Anda berbeda, Anda perlu menentukannya. Dalam kasus ini, nama tabel sudah 'users'.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Kunci primer model.
     * Secara default, Laravel mengasumsikan kunci primer adalah 'id'.
     * Karena kunci primer Anda adalah 'id_user', Anda harus menentukannya.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * Menunjukkan apakah kunci primer adalah auto-incrementing.
     * Secara default, ini adalah true.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data dari kunci primer.
     * Secara default, ini adalah 'int'.
     * Jika kunci primer Anda bukan integer (misal: UUID), Anda perlu menentukannya.
     * Karena `id_user` adalah `serial` (integer besar), 'int' atau 'string' jika UUID.
     *
     * @var string
     */
    protected $keyType = 'int';


    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Kolom-kolom di sini dapat diisi langsung menggunakan metode `create` atau `fill`.
     * Tambahkan semua kolom yang boleh diisi oleh pengguna.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_role',
        'nama_lengkap',
        'nomor_identitas',
        'no_telepon',
        'username',
        'password',
        'email',
        'jalan',
        'desa',
        'kecamatan',
        'kota',
        'provinsi',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     * Ini berguna untuk menyembunyikan data sensitif (seperti password) saat model dikonversi ke array/JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     * Misalnya, kolom timestamp harus di-cast ke objek `DateTime`.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Jika Anda menggunakan fitur verifikasi email
        // Anda juga bisa menambahkan casting untuk kolom lain jika diperlukan,
        // contoh: 'is_active' => 'boolean'
    ];

    /**
     * Definisikan relasi 'belongsTo' dengan model Role.
     * Seorang user 'memiliki' satu role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        // Parameter pertama: Nama model terkait (Role::class)
        // Parameter kedua: Foreign key di model saat ini (User), yaitu 'id_role'
        // Parameter ketiga: Primary key di model terkait (Role), yaitu 'id_role'
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}