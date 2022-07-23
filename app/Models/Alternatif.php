<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $timestamps = false;
    protected $table = "guru";
    protected $fillable = [
        "kode_guru",
        "nama",
        "tempat_lahir",
        "tanggal_lahir",
        "nip",
        "jenis_kelamin",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public function getAutoKodeAlternatif()
    {
        $users = DB::select(
            "select RIGHT(kode_guru,3) as kode from guru ORDER BY kode_guru DESC  LIMIT 1"
        );
        if ($users) {
            $kode = intval($users[0]->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodejadi = "GRU" . $kodemax;
        return $kodejadi;
    }
}
