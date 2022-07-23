<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Perbandingan extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $table = "perbandingan";
    protected $fillable = [
        "kode_perbandingan",
        "kode_ahp",
        "kode_kriteria1",
        "kode_kriteria2",
        "nilai",
    ];

    public function getPerbandinganByKriteria1($kriteria1)
    {
        $kriteria2 = DB::table("perbandingan")
            ->select("nilai", "kode_kriteria2", "kode_kriteria1")
            ->where("kode_kriteria2", "=", $kriteria1)
            ->get();

        return $kriteria2;
    }

    public function getNilaiPerbandingan($kode_kriteria)
    {
        $nilai_perbandingan = DB::table("perbandingan")
            ->select("nilai", "kode_kriteria1")
            ->where("kode_kriteria1", "=", $kode_kriteria)
            ->get();

        return $nilai_perbandingan;
    }
}
