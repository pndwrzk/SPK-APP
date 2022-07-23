<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Hasil;
use App\Models\Surat_Keputusan;
use App\Models\Penilaian;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasil_model = new Hasil();
        $hasil = $hasil_model->getAllHasilGroupByPeriode();
        return $hasil;
    }
    public function show($periode)
    {
        $hasil_model = new Hasil();
        $nilai_akhir = $hasil_model->getNilaiAkhirByPeriode($periode);
        return $nilai_akhir;
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "tahun_penilaian" => "required",
        ]);

        if ($validation->fails()) {
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        }

        $cek = DB::table("hasil")
            ->where("periode", $request->tahun_penilaian)
            ->get();

        if (count($cek) > 0) {
            $errors = [
                "tahun_penilaian" => [
                    "penilaian di periode " .
                    $request->tahun_penilaian .
                    " sudah pernah dilakukan",
                ],
            ];
            $data = [
                "status" => false,
                "message" => $errors,
            ];
            return response()->json($data, 422);
        }

        $data_arr = [];
        $a = 0;
        for ($i = 0; $i < count($request->alternatif); $i++) {
            $kode_alternatif = $request->alternatif[$i]["kode_guru"];
            for ($j = 0; $j < count($request->kriteria); $j++) {
                $kode_kriteria = $request->kriteria[$j]["kode_kriteria"];
                $data_arr[$a] = [
                    "kode_guru" => $kode_alternatif,
                    "kode_kriteria" => $kode_kriteria,
                    "nilai" => $request->matriks[$a],
                ];
                $a++;
            }
        }
        $maxmin = $this->getMaxMin($data_arr);
        $hasilnormalisasi = $this->matriks_normalisasi($data_arr, $maxmin);
        $hasil = $this->nilai_preferensi($hasilnormalisasi);
        $this->save_hasil($data_arr, $hasil, $request->tahun_penilaian);

        $data = [
            "status" => true,
            "message" => "Data penilaian berhasil ditambahkan",
            "periode" => $request->tahun_penilaian,
        ];

        return response()->json($data, 200);
    }

    public function save_hasil($data_arr, $hasil, $periode)
    {
        // for ($i = 0; $i <= 14; $i++) {
        //     $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        //     $kodejadi = "SAW" . $kodemax;

        //     $array[$i] = [
        //         "kode" => $kodejadi,
        //     ];
        //     $kode++;
        // }

        $kriteria = DB::table("kriteria")->get();

        // $juara = 1;
        $index = 0;
        $indexHasil = 0;
        $array_hasil = [];
        $hasilModel = new Hasil();
        $kode = $hasilModel->getAutoKodeHasil();
        for ($i = 0; $i < count($hasil); $i++) {
            $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
            $kode_hasil = "SAW" . $kodemax;

            $array_hasil[$i] = [
                "kode_hasil" => $kode_hasil,
                "nilai_saw" => $hasil[$i]["hasil"],
            ];
            // $hasilModel->kode_hasil = $kode_hasil;
            // $hasilModel->nilai_saw = $hasil[$i]["hasil"];
            // $hasilModel->periode = $periode;
            // $hasilModel->keterangan = "Juara " . $juara;
            // $hasilModel->save();
            // $juara++;

            for ($j = 0; $j < count($kriteria); $j++) {
                $matriksModel = new Penilaian();
                $kode_penilaian = IdGenerator::generate([
                    "table" => "penilaian",
                    "field" => "kode_penilaian",
                    "length" => 6,
                    "prefix" => "PNL",
                ]);
                $kode_kriteria = $data_arr[$index]["kode_kriteria"];
                $kode_guru = $data_arr[$index]["kode_guru"];
                $nilai = $data_arr[$index]["nilai"];

                $matriksModel->kode_penilaian = $kode_penilaian;
                $matriksModel->kode_hasil = $kode_hasil;
                $matriksModel->kode_guru = $kode_guru;
                $matriksModel->kode_kriteria = $kode_kriteria;
                $matriksModel->nilai = $nilai;
                $matriksModel->save();
                $index++;
            }
            $kode++;
            $indexHasil++;
        }

        // :(

        // $hasilbaru = Hasil::where("periode", $periode)
        //     ->get()
        //     ->toArray();

        // -----------------------------------------------------------------
        foreach ($array_hasil as $key => $isi) {
            $kode_hasil[$key] = $isi["kode_hasil"];
            $nilai_saw[$key] = $isi["nilai_saw"];
        }

        $kode_hasil = array_column($array_hasil, "kode_hasil");
        $nilai_saw = array_column($array_hasil, "nilai_saw");
        // $periode = array_column($array_hasil, "periode");

        array_multisort($nilai_saw, SORT_DESC, $array_hasil);

        // DB::table("hasil")
        //     ->where("periode", $periode)
        //     ->delete();

        $juara = 1;
        foreach ($array_hasil as $isi) {
            $hasilModel = new Hasil();
            $hasilModel->kode_hasil = $isi["kode_hasil"];
            $hasilModel->nilai_saw = $isi["nilai_saw"];
            $hasilModel->periode = $periode;
            $hasilModel->keterangan = "Rangking " . $juara;
            $hasilModel->save();
            $juara++;
        }
    }

    public function nilai_preferensi($matriks)
    {
        $kriteria = DB::table("kriteria")->get();
        $hasil = 0;
        $j = 0;
        $index = 0;
        $jumlah = 0;

        for ($i = 0; $i < count($matriks); $i++) {
            $hasil =
                $hasil +
                json_decode(
                    number_format(
                        abs($matriks[$i]["nilai"] * $kriteria[$j]->bobot),
                        4
                    )
                );
            $jumlah = $jumlah + $matriks[$i]["nilai"];
            $j++;

            if ($j == count($kriteria)) {
                $nilai_arr[$index] = [
                    "hasil" => json_decode(number_format(abs($hasil), 4)),
                ];
                $hasil = 0;
                $jumlah = 0;
                $j = 0;
                $index++;
            }
        }

        // foreach ($nilai_arr as $key => $isi) {
        //     $poin1[$key] = $isi["hasil"];
        // }

        // array_multisort($poin1, SORT_DESC, $nilai_arr);

        return $nilai_arr;
    }

    public function matriks_normalisasi($data_arr, $maxmin)
    {
        $kriteria = DB::table("kriteria")->get();

        $k = 0;
        $hasil = 0;

        for ($i = 0; $i < count($data_arr); $i++) {
            if ($k < count($kriteria)) {
                if ($kriteria[$k]->atribut === "benefit") {
                    $hasil = number_format(
                        abs(
                            $data_arr[$i]["nilai"] / $maxmin["max"][$k]["nilai"]
                        ),
                        4
                    );
                    $k++;
                } elseif ($kriteria[$k]->atribut === "cost") {
                    $hasil = number_format(
                        abs(
                            $maxmin["min"][$k]["nilai"] / $data_arr[$i]["nilai"]
                        ),
                        4
                    );
                    $k++;
                }
            } else {
                $k = 0;
                if ($kriteria[$k]->atribut === "benefit") {
                    $hasil = number_format(
                        abs(
                            $data_arr[$i]["nilai"] / $maxmin["max"][$k]["nilai"]
                        ),
                        4
                    );
                    $k++;
                } elseif ($kriteria[$k]->atribut === "cost") {
                    $hasil = number_format(
                        abs(
                            $maxmin["min"][$k]["nilai"] / $data_arr[$i]["nilai"]
                        ),
                        4
                    );
                    $k++;
                }
            }

            $hasil_arr[$i] = [
                "kode_kriteria" => $data_arr[$i]["kode_kriteria"],
                "kode_guru" => $data_arr[$i]["kode_guru"],
                "nilai" => $hasil,
            ];
        }

        return $hasil_arr;
    }

    public function getMaxMin($data_arr)
    {
        $max_arr = [];
        $min_arr = [];
        $kriteria = DB::table("kriteria")->get();
        for ($a = 0; $a < count($kriteria); $a++) {
            $max = $data_arr[$a]["nilai"];
            $min = $data_arr[$a]["nilai"];
            for ($i = 0; $i < count($data_arr); $i++) {
                if (
                    $kriteria[$a]->kode_kriteria ==
                    $data_arr[$i]["kode_kriteria"]
                ) {
                    if ($max <= $data_arr[$i]["nilai"]) {
                        $max = $data_arr[$i]["nilai"];
                    }
                    if ($min >= $data_arr[$i]["nilai"]) {
                        $min = $data_arr[$i]["nilai"];
                    }
                }
            }

            $max_arr[$a] = [
                "kode_kriteria" => $kriteria[$a]->kode_kriteria,
                "nilai" => $max,
            ];
            $min_arr[$a] = [
                "kode_kriteria" => $kriteria[$a]->kode_kriteria,
                "nilai" => $min,
            ];
        }

        return [
            "max" => $max_arr,
            "min" => $min_arr,
        ];
    }

    public function columnMatriks()
    {
        $kriteria = kriteria::all();
        $alternatif = Alternatif::all();
        $nilaibobot = DB::table("kriteria")
            ->select("bobot")
            ->get();
        $bobot = true;
        foreach ($nilaibobot as $b) {
            if ($b->bobot == null) {
                $bobot = false;
            }
        }

        $data = [
            "kriteria" => $kriteria,
            "alternatif" => $alternatif,
            "bobot" => $bobot,
        ];

        return response()->json($data);
    }

    public function getHasilPenilaian($periode)
    {
        $penilaian_model = new Penilaian();
        $hasil_model = new Hasil();

        $alternatif = $penilaian_model->getAlternatifByPeriode($periode);
        $kriteria = $penilaian_model->getKriteriaByPeriode($periode);
        $nilai_awal = $hasil_model->getNilaiAwalByPeriode($periode);
        $hasil_akhir = $hasil_model->getNilaiAkhirByPeriode($periode);
        $Maxmin = $this->getMaxMin($nilai_awal);
        $hasilnormalisasi = $this->matriks_normalisasi($nilai_awal, $Maxmin);

        $data = [
            "kriteria" => $kriteria,
            "guru" => $alternatif,
            "nilai_awal" => $nilai_awal,
            "nilai_matriks" => $hasilnormalisasi,
            "hasil_akhir" => $hasil_akhir,
        ];

        return $data;
    }

    public function destroy($periode)
    {
        $penilaian_model = new Penilaian();
        $sk_model = new Surat_Keputusan();
        $hasil_model = new Hasil();

        $penilaian_model->deletePenilaianbyPeriode($periode);
        $sk_model->deleteSKByPeriode($periode);
        $hasil_model->deleteHasilByPeriode($periode);

        $data_respone = [
            "status" => true,
            "message" => "Data penilaian berhasil dihapus",
        ];

        return $data_respone;
    }

    public function cetak_laporan_perangkingan($periode)
    {
        $hasil_model = new Hasil();
        $hasil = $hasil_model->getNilaiAkhirByPeriode($periode);

        $pdf = new Fpdf();
        $pdf->AddPage("P", "A4");
        $pdf->Image("images/lambang_Kota_Tangerang.png", 11, 5, 31, 31);
        $pdf->Cell(25);
        $pdf->SetTextColor(61, 68, 99);
        $pdf->SetFont("Times", "B", "14");
        $pdf->Cell(0, 5, "PEMERINTAH KOTA TANGERANG", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "DINAS PENDIDIKAN", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "UPT SATUAN PENDIDIKAN", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "SD NEGERI JURUMUDI 1", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->SetFont("Times", "B", 9);
        // Removes bold
        $pdf->SetFont("");
        $pdf->Cell(
            0,
            3,
            "Alamat : Jl.Halim Perdana Kusuma, Kel. Jurumudi, Kec. Benda, Konta Tangerang Banten Kode Pos 15124",
            0,
            1,
            "C"
        );
        $pdf->Cell(25);
        $pdf->Cell(0, 3, "Email : sdnjurumudisatu@yahoo.com", 0, 1, "C");

        $pdf->SetFont("Times", "B", "12");
        $pdf->Cell(
            0,
            5,
            "NSS : 101280504004                                                    TANGERANG",
            0,
            0,
            "L"
        );
        $pdf->Cell(0, 5, "NPSN : 20606975", 0, 0, "R");

        $pdf->SetLineWidth(1);

        $pdf->Line(10, 41, 198, 41);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 42, 198, 42);
        $pdf->Ln(14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont("Times", "BU", "14");
        $pdf->Cell(0, 5, "LAPORAN PERANGKINGAN GURU", 0, 1, "C");
        $pdf->Ln(10);

        $pdf->SetFont("Times", "B", "12");
        $pdf->SetFont("Times", "B", "12");
        $pdf->Cell(15, 5, "Periode", 0, 0, "L");
        $pdf->SetFont("Times", "", "12");
        $pdf->Cell(50, 5, " : " . $periode, 0, 1, "L");
        $pdf->Ln(8);
        $pdf->SetFont("Times", "B", "13");
        $pdf->Cell(20, 9, "NO", 1, 0, "C");
        $pdf->Cell(70, 9, "Nama", 1, 0, "C");
        $pdf->Cell(50, 9, "Nilai", 1, 0, "C");
        $pdf->Cell(50, 9, "Keterangan", 1, 1, "C");
        $no = 1;

        $pdf->SetFont("Times", "", "12");
        foreach ($hasil as $h) {
            $pdf->Cell(20, 9, $no++, 1, 0, "C");
            $pdf->Cell(70, 9, $h["nama"], 1, 0, "C");
            $pdf->Cell(50, 9, $h["nilai_saw"], 1, 0, "C");
            $pdf->Cell(50, 9, $h["keterangan"], 1, 1, "C");
        }

        $pdf->Ln(30);
        $pdf->SetFont("Times", "", "12");
        date_default_timezone_set("Asia/Jakarta");
        // $currentdate = date("d-M-Y");
        $pdf->Cell(
            326,
            9,
            "Tangerang, " .
                date("d") .
                "-" .
                getBulan(date("m")) .
                "-" .
                date("Y"),
            0,
            1,
            "C"
        );
        $pdf->Cell(305, 3, "Mengetahui,", 0, 1, "C");
        $pdf->Cell(310, 5, "Kepala Sekolah", 0, 1, "C");

        $pdf->SetFont("Times", "BU", "12");
        $pdf->Cell(329, 60, "Drs.H.MAHPUJI               ", 0, 1, "C");
        $pdf->SetFont("Times", "", "12");
        $pdf->Cell(327, -50, "NIP:196306211984101010", 0, 1, "C");

        $pdf->Output();
        exit();
    }

    public function buat_keputusan($kode_hasil)
    {
        $hasil = DB::table("hasil")
            ->select("periode")
            ->where("hasil.kode_hasil", $kode_hasil)
            ->first();

        date_default_timezone_set("Asia/Jakarta");
        $date_save = date("Y-m-d");
        $kode_sk = IdGenerator::generate([
            "table" => "surat_keputusan",
            "field" => "kode_suratkeputusan",
            "length" => 6,
            "prefix" => "SK",
        ]);

        $sk_model = new Surat_Keputusan();
        $sk_model->kode_suratkeputusan = $kode_sk;
        $sk_model->kode_hasil = $kode_hasil;
        $sk_model->tanggal = $date_save;
        $sk_model->save();

        return redirect("/penilaian/$hasil->periode/pilih-alternatif-terbaik");
    }

    public function cetak_laporan_penilaian($periode)
    {
        $penilaian_model = new Penilaian();
        $hasil_model = new Hasil();

        $alternatif = $penilaian_model->getAlternatifByPeriode($periode);
        $kriteria = $penilaian_model->getKriteriaByPeriode($periode);
        $nilai_awal = $hasil_model->getNilaiAwalByPeriode($periode);

        $hasil_akhir = $hasil_model->getNilaiAkhirByPeriode($periode);

        $pdf = new Fpdf();
        $pdf->AddPage("P", "A4");
        $pdf->Image("images/lambang_Kota_Tangerang.png", 11, 5, 31, 31);
        $pdf->Cell(25);
        $pdf->SetTextColor(61, 68, 99);
        $pdf->SetFont("Times", "B", "14");
        $pdf->Cell(0, 5, "PEMERINTAH KOTA TANGERANG", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "DINAS PENDIDIKAN", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "UPT SATUAN PENDIDIKAN", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->Cell(0, 5, "SD NEGERI JURUMUDI 1", 0, 1, "C");
        $pdf->Cell(25);
        $pdf->SetFont("Times", "B", 9);
        // Removes bold
        $pdf->SetFont("");
        $pdf->Cell(
            0,
            3,
            "Alamat : Jl.Halim Perdana Kusuma, Kel. Jurumudi, Kec. Benda, Konta Tangerang Banten Kode Pos 15124",
            0,
            1,
            "C"
        );
        $pdf->Cell(25);
        $pdf->Cell(0, 3, "Email : sdnjurumudisatu@yahoo.com", 0, 1, "C");

        $pdf->SetFont("Times", "B", "12");
        $pdf->Cell(
            0,
            5,
            "NSS : 101280504004                                                    TANGERANG",
            0,
            0,
            "L"
        );
        $pdf->Cell(0, 5, "NPSN : 20606975", 0, 0, "R");

        $pdf->SetLineWidth(1);

        $pdf->Line(10, 41, 198, 41);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 42, 198, 42);
        $pdf->Ln(14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont("Times", "BU", "14");
        $pdf->Cell(0, 5, "LAPORAN PENILAIAN GURU", 0, 1, "C");
        $pdf->Ln(10);

        $pdf->SetFont("Times", "B", "12");
        $pdf->SetFont("Times", "B", "12");
        $pdf->Cell(15, 5, "Periode", 0, 0, "L");
        $pdf->SetFont("Times", "", "12");
        $pdf->Cell(50, 5, " : " . $periode, 0, 1, "L");
        $pdf->Ln(8);
        $pdf->SetFont("Times", "B", "9");
        $pdf->Cell(10, 9, "NO", 1, 0, "C");
        $pdf->Cell(30, 9, "Nama", 1, 0, "C");
        foreach ($kriteria as $k) {
            if ($k->kode_kriteria == "KRT005") {
                $pdf->Cell(29, 9, $k->nama, 1, 0, "C");
            } else {
                $pdf->Cell(20, 9, $k->nama, 1, 0, "C");
            }
        }
        $pdf->Cell(20, 9, "Nilai", 1, 1, "C");

        $no = 1;
        $pdf->SetFont("Times", "", "9");
        foreach ($alternatif as $a) {
            $pdf->Cell(10, 9, $no++, 1, 0, "C");
            $pdf->Cell(30, 9, $a->nama, 1, 0, "C");
            foreach ($nilai_awal as $n) {
                if ($n->kode_guru == $a->kode_guru) {
                    if ($n->kode_kriteria == "KRT005") {
                        $pdf->Cell(29, 9, $n->nilai, 1, 0, "C");
                    } else {
                        $pdf->Cell(20, 9, $n->nilai, 1, 0, "C");
                    }
                }
            }
            foreach ($hasil_akhir as $h) {
                if ($h["kode_guru"] == $a->kode_guru) {
                    $pdf->Cell(20, 9, $h["nilai_saw"], 1, 1, "C");
                }
            }
        }
        $pdf->SetFont("Times", "", "12");
        $pdf->Ln(30);
        date_default_timezone_set("Asia/Jakarta");
        // $currentdate = date("d-M-Y");
        $pdf->Cell(
            326,
            9,
            "Tangerang, " .
                date("d") .
                "-" .
                getBulan(date("m")) .
                "-" .
                date("Y"),
            0,
            1,
            "C"
        );
        $pdf->Cell(305, 3, "Mengetahui,", 0, 1, "C");
        $pdf->Cell(310, 5, "Kepala Sekolah", 0, 1, "C");

        $pdf->SetFont("Times", "BU", "12");
        $pdf->Cell(329, 60, "Drs.H.MAHPUJI               ", 0, 1, "C");
        $pdf->SetFont("Times", "", "12");
        $pdf->Cell(327, -50, "NIP:196306211984101010", 0, 1, "C");

        $pdf->Output();
        exit();
    }
}
