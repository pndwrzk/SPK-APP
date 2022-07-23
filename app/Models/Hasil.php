<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    public $timestamps = false;

    protected $table = "hasil";
    protected $fillable = ["kode_hasil", "periode", "nilai_saw", "keterangan"];

    public function getAutoKodeHasil()
    {
        $kode_hasil = DB::select(
            "select RIGHT(kode_hasil,3) as kode from hasil ORDER BY kode_hasil DESC  LIMIT 1"
        );

        if ($kode_hasil) {
            $kode = intval($kode_hasil[0]->kode) + 1;
        } else {
            $kode = 1;
        }
        // $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        // $kodejadi = "KRT" . $kodemax;
        return $kode;
    }

    public function getAllHasilGroupByPeriode()
    {
        $periode = DB::table("hasil")
            ->groupBy("periode")
            ->get();
        return $periode;
    }

    public function getNilaiAwalByPeriode($periode)
    {
        $nilai_awal = Hasil::join(
            "penilaian",
            "hasil.kode_hasil",
            "=",
            "penilaian.kode_hasil"
        )
            ->groupBy("penilaian.kode_penilaian")
            ->where("periode", "=", $periode)
            ->get(["penilaian.*"]);

        return $nilai_awal;
    }

    public function getNilaiAkhirByPeriode($periode)
    {
        $hasil_akhir = Hasil::join(
            "penilaian",
            "hasil.kode_hasil",
            "penilaian.kode_hasil"
        )
            ->join("guru", "penilaian.kode_guru", "guru.kode_guru")
            ->groupBy("penilaian.kode_hasil")
            ->where("periode", "=", $periode)
            ->get([
                "guru.nama",
                "guru.kode_guru",
                "hasil.nilai_saw",
                "hasil.keterangan",
                "hasil.kode_hasil",
            ])
            ->toArray();

        foreach ($hasil_akhir as $key => $isi) {
            $nama[$key] = $isi["nama"];
            $keterangan[$key] = $isi["keterangan"];
            $kode_hasil[$key] = $isi["kode_hasil"];
            $nilai_saw[$key] = $isi["nilai_saw"];
        }

        $nama = array_column($hasil_akhir, "nama");
        $keterangan = array_column($hasil_akhir, "keterangan");
        $kode_hasil = array_column($hasil_akhir, "kode_hasil");
        $nilai_saw = array_column($hasil_akhir, "nilai_saw");

        array_multisort($nilai_saw, SORT_DESC, $hasil_akhir);

        // $hasil_akhir = DB::table("hasil")
        //     ->join("penilaian", "hasil.kode_hasil", "penilaian.kode_hasil")
        //     ->join("guru", "penilaian.kode_guru", "guru.kode_guru")
        //     ->select(
        //         "guru.nama",
        //         "hasil.nilai_saw",
        //         "hasil.keterangan",
        //         "hasil.kode_hasil"
        //     )
        //     ->where("periode", $periode)
        //     ->groupBy("penilaian.kode_hasil")
        //     ->get();

        return $hasil_akhir;
    }

    public function deleteHasilByPeriode($periode)
    {
        DB::table("hasil")
            ->where("hasil.periode", $periode)
            ->delete();
    }
}
