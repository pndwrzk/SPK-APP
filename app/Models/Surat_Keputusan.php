<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Surat_Keputusan extends Model
{
    public $timestamps = false;
    protected $table = "surat_keputusan";
    protected $fillable = ["kode_suratkeputusan", "kode_hasil", "tanggal"];

    public function getAllSK()
    {
        $sk = DB::table("surat_keputusan")
            ->join(
                "hasil",
                "surat_keputusan.kode_hasil",
                "=",
                "hasil.kode_hasil"
            )
            ->join("penilaian", "hasil.kode_hasil", "=", "penilaian.kode_hasil")
            ->join("guru", "penilaian.kode_guru", "=", "guru.kode_guru")
            ->select("hasil.*", "surat_keputusan.*", "guru.nama")
            ->groupBy("hasil.kode_hasil")
            ->get();
        return $sk;
    }

    public function getSKByPeriode($periode)
    {
        $data = DB::table("surat_keputusan")
            ->join(
                "hasil",
                "surat_keputusan.kode_hasil",
                "=",
                "hasil.kode_hasil"
            )
            ->join("penilaian", "hasil.kode_hasil", "=", "penilaian.kode_hasil")
            ->join("guru", "penilaian.kode_guru", "=", "guru.kode_guru")
            ->select("hasil.*", "surat_keputusan.*", "guru.nama", "guru.nip")
            ->groupBy("guru.kode_guru")
            ->where("hasil.periode", $periode)
            ->get();

        return $data;
    }

    public function getSKByKodeHasil($kode_hasil)
    {
        $sk = DB::table("surat_keputusan")
            ->join(
                "hasil",
                "surat_keputusan.kode_hasil",
                "=",
                "hasil.kode_hasil"
            )
            ->join("penilaian", "hasil.kode_hasil", "=", "penilaian.kode_hasil")
            ->join("guru", "penilaian.kode_guru", "=", "guru.kode_guru")
            ->select(
                "hasil.periode",
                "hasil.nilai_saw",
                "surat_keputusan.*",
                "guru.nama",
                "guru.nip"
            )
            ->groupBy("hasil.kode_hasil")
            ->where("hasil.kode_hasil", $kode_hasil)
            ->get()[0];

        return $sk;
    }

    public function deleteSKByPeriode($periode)
    {
        DB::table("surat_keputusan")
            ->leftJoin(
                "hasil",
                "surat_keputusan.kode_hasil",
                "=",
                "hasil.kode_hasil"
            )
            ->where("hasil.periode", $periode)
            ->delete();
    }

    public function getLaporanSK($periode_awal, $periode_akhir)
    {
        $sk = DB::table("surat_keputusan")
            ->join(
                "hasil",
                "surat_keputusan.kode_hasil",
                "=",
                "hasil.kode_hasil"
            )
            ->join("penilaian", "hasil.kode_hasil", "=", "penilaian.kode_hasil")
            ->join("guru", "penilaian.kode_guru", "=", "guru.kode_guru")
            ->where("hasil.periode", ">=", $periode_awal)
            ->where("hasil.periode", "<=", $periode_akhir)
            ->select("hasil.*", "surat_keputusan.*", "guru.nama")
            ->groupBy("hasil.kode_hasil")
            ->get();

        return $sk;
    }
}
