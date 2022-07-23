<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    public $timestamps = false;

    protected $table = "penilaian";
    protected $fillable = [
        "kode_penilaian",
        "kode_guru",
        "kode_kriteria",
        "kode_hasil",
        "nilai",
    ];

    public function getAutoKodeMatriks()
    {
        $matriks = DB::select(
            "select RIGHT(kode_penilaian,3) as kode from penilaian ORDER BY kode_penilaian DESC  LIMIT 1"
        );
        if ($matriks) {
            $kode = intval($matriks[0]->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodejadi = "PNL" . $kodemax;
        return $kodejadi;
    }

    public function getAlternatifByPeriode($periode)
    {
        $alternatif = DB::table("hasil")
            ->join("penilaian", "hasil.kode_hasil", "penilaian.kode_hasil")
            ->join("guru", "penilaian.kode_guru", "guru.kode_guru")
            ->select("guru.nama", "guru.kode_guru")
            ->where("periode", $periode)
            ->groupBy("penilaian.kode_guru")
            ->orderBy("guru.kode_guru")
            ->get();

        return $alternatif;
    }

    public function getKriteriaByPeriode($periode)
    {
        $kriteria = DB::table("hasil")
            ->join("penilaian", "hasil.kode_hasil", "penilaian.kode_hasil")
            ->join(
                "kriteria",
                "penilaian.kode_kriteria",
                "kriteria.kode_kriteria"
            )
            ->select(
                "kriteria.nama",
                "kriteria.bobot",
                "kriteria.kode_kriteria"
            )
            ->where("periode", $periode)
            ->groupBy("penilaian.kode_kriteria")
            ->get();

        return $kriteria;
    }

    public function deletePenilaianbyPeriode($periode)
    {
        DB::table("penilaian")
            ->leftJoin("hasil", "penilaian.kode_hasil", "=", "hasil.kode_hasil")
            ->where("hasil.periode", $periode)
            ->delete();
    }
}
