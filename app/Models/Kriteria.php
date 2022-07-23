<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    public $timestamps = false;
    protected $table = "kriteria";
    protected $fillable = ["kode_kriteria", "nama", "bobot", "atribut"];

    public function getAutoKodeKriteria()
    {
        $Kriteria = DB::select(
            "select RIGHT(kode_kriteria,3) as kode from kriteria ORDER BY kode_kriteria DESC  LIMIT 1"
        );
        if ($Kriteria) {
            $kode = intval($Kriteria[0]->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodejadi = "KRT" . $kodemax;
        return $kodejadi;
    }

    public function getAllKriteria()
    {
        $kriteria = DB::table("kriteria")
            ->select("kode_kriteria", "nama")
            ->get();

        return $kriteria;
    }

    public function getKriteriaPerbandingan()
    {
        $kriteria = DB::table("perbandingan")
            ->join(
                "kriteria",
                "perbandingan.kode_kriteria1",
                "kriteria.kode_kriteria"
            )
            ->select(
                "perbandingan.kode_kriteria1 as kode_kriteria",
                "kriteria.nama"
            )
            ->groupBy("kode_kriteria1")
            ->get();

        return $kriteria;
    }
}
