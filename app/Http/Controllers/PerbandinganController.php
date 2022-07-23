<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Perbandingan;
use App\Models\Surat_Keputusan;
use App\Models\Hasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Codedge\Fpdf\Fpdf\Fpdf;

class PerbandinganController extends Controller
{
    public function index()
    {
        $perbandingan = DB::table("perbandingan")->get();
        return count($perbandingan);
    }

    public function simpan_perbandingan(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "baris" => "required",
            "kolom" => "required",
        ]);

        if ($validation->fails()) {
            $data = [
                "status" => false,
                "message" => "Perbandingan Antar Kriteria Harus Terisi Lengkap",
            ];
            return response()->json($data, 422);
        }

        $kriteria = DB::table("kriteria")
            ->select("kode_kriteria")
            ->get();
        DB::table("perbandingan")->delete();

        $a = 0;
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = $i; $j < count($kriteria); $j++) {
                $perbandingan = new Perbandingan();
                $kode_perbandingan = IdGenerator::generate([
                    "table" => "perbandingan",
                    "field" => "kode_perbandingan",
                    "length" => 6,
                    "prefix" => "AHP",
                ]);
                $perbandingan->kode_perbandingan = $kode_perbandingan;
                $perbandingan->kode_kriteria1 = $kriteria[$i]->kode_kriteria;
                $perbandingan->kode_kriteria2 = $kriteria[$j]->kode_kriteria;
                if ($request->kolom[$a] > $request->baris[$a]) {
                    $nilai = 0 - $request->kolom[$a];
                } else {
                    $nilai = $request->baris[$a];
                }
                $perbandingan->nilai = $nilai;
                $perbandingan->save();
                $a++;
            }
        }

        $data = [
            "status" => true,
            "message" =>
                "Perbandingan berhasil dibuat, Bobot Kriteria Sudah Diperbaharui ",
        ];

        return response()->json($data);
    }

    public function getHasilPerbandingan()
    {
        // $matriks_perbandingan = null;
        // $matriks_awal = null;

        $kriteria_model = new Kriteria();
        $perbandingan_model = new Perbandingan();

        $kriteria = $kriteria_model->getKriteriaPerbandingan();

        $a = 0;
        foreach ($kriteria as $k) {
            $kode_kriteria = $k->kode_kriteria;

            $perbandingan = $perbandingan_model->getPerbandinganByKriteria1(
                $kode_kriteria
            );

            if ($perbandingan) {
                foreach ($perbandingan as $hk) {
                    if ($hk->kode_kriteria2 !== $hk->kode_kriteria1) {
                        if ($hk->nilai < 0) {
                            $nilai = number_format(abs($hk->nilai / 1), 4);
                            $nilai2 = abs($hk->nilai) . "/1";
                        } else {
                            $nilai = number_format(abs(1 / $hk->nilai), 4);
                            $nilai2 = "1/" . abs($hk->nilai);
                        }
                        $matriks_perbandingan[$a] = [
                            "nilai" => $nilai,
                            "kode_kriteria" => $kode_kriteria,
                        ];
                        $matriks_awal[$a] = [
                            "nilai" => $nilai2,
                            "kode_kriteria" => $kode_kriteria,
                        ];

                        $a++;
                    }
                }

                $nilaiPerbandingan = $perbandingan_model->getNilaiPerbandingan(
                    $kode_kriteria
                );

                foreach ($nilaiPerbandingan as $hb) {
                    if ($hb->nilai < 0) {
                        $nilai = number_format(abs(1 / $hb->nilai), 4);
                        $nilai2 = "1/" . abs($hb->nilai);
                    } elseif ($hb->nilai > 1) {
                        $nilai = number_format(abs($hb->nilai / 1), 4);
                        $nilai2 = abs($hb->nilai) . "/1";
                    } else {
                        $nilai = number_format(abs($hb->nilai), 4);
                        $nilai2 = abs($hb->nilai) . "/1";
                    }

                    $matriks_perbandingan[$a] = [
                        "nilai" => $nilai,
                        "kode_kriteria" => $kode_kriteria,
                    ];
                    $matriks_awal[$a] = [
                        "nilai" => $nilai2,
                        "kode_kriteria" => $kode_kriteria,
                    ];
                    $a++;
                }
            }
            //    unset($matriks_perbandingan[$a][$a]);
            //  $matriks_perbandingan[$a] =  array_values($matriks_perbandingan[$a]);
        }

        $array_jumlah = null;
        for ($j = 0; $j < count($kriteria); $j++) {
            $jumlah = 0;
            for (
                $i = $j;
                $i < count($matriks_perbandingan);
                $i = $i + count($kriteria)
            ) {
                $jumlah = $jumlah + $matriks_perbandingan[$i]["nilai"];
            }
            $array_jumlah[$j] = ["jumlah" => number_format(abs($jumlah), 4)];
        }

        $array_normalisasi = null;
        $a = 0;
        $array_filter = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = 0; $j < count($matriks_perbandingan); $j++) {
                if (
                    $kriteria[$i]->kode_kriteria ==
                    $matriks_perbandingan[$j]["kode_kriteria"]
                ) {
                    array_push(
                        $array_filter,
                        $matriks_perbandingan[$j]["nilai"]
                    );
                }
            }

            for ($k = 0; $k < count($matriks_perbandingan); $k++) {
                for ($m = 0; $m < count($array_filter); $m++) {
                    $kolom = $m;
                    $hasil = 0;
                    for ($l = 0; $l < count($array_filter); $l++) {
                        $hasil =
                            $hasil +
                            $array_filter[$l] *
                                $matriks_perbandingan[$kolom]["nilai"];
                        $kolom = $kolom + count($array_filter);
                    }

                    $array_normalisasi[$a] = [
                        "nilai" => number_format(abs($hasil), 4),
                        "kode_kriteria" => $kriteria[$i]->kode_kriteria,
                    ];
                    $a++;
                }
                $array_filter = [];
            }
        }

        $total_jumlah_baris = 0;

        foreach ($array_normalisasi as $an) {
            $total_jumlah_baris = number_format(
                abs($total_jumlah_baris + $an["nilai"]),
                4
            );
        }

        $array_BobotPrioritas = null;
        $jumlah_baris = 0;
        $index_kriteria = 0;
        $j = 0;
        for ($i = 0; $i < count($array_normalisasi); $i++) {
            $jumlah_baris = $jumlah_baris + $array_normalisasi[$i]["nilai"];

            if ($index_kriteria == count($kriteria) - 1) {
                $array_BobotPrioritas[$j] = [
                    "jumlah_baris" => number_format(abs($jumlah_baris), 4),
                    "bobot" => number_format(
                        abs($jumlah_baris / $total_jumlah_baris),
                        4
                    ),
                    "kode_kriteria" => $kriteria[$j]->kode_kriteria,
                ];
                $j++;
                $jumlah_baris = 0;
                $index_kriteria = 0;
            } else {
                $index_kriteria++;
            }
        }

        $array_CM = null;
        $cm = 0;
        $indexbobot = 0;
        $j = 0;
        for ($i = 0; $i < count($matriks_perbandingan); $i++) {
            $cm = number_format(
                abs(
                    $cm +
                        $matriks_perbandingan[$i]["nilai"] *
                            $array_BobotPrioritas[$indexbobot]["bobot"]
                ),
                4
            );
            if ($indexbobot == count($kriteria) - 1) {
                $array_CM[$j] = [
                    "cm" => number_format(
                        abs($cm / $array_BobotPrioritas[$j]["bobot"]),
                        4
                    ),
                    "kode_kriteria" => $kriteria[$j]->kode_kriteria,
                    "kali_matriks" => $cm,
                ];
                $j++;
                $cm = 0;
                $indexbobot = 0;
            } else {
                $indexbobot++;
            }
        }

        $total_cm = 0;
        foreach ($array_CM as $cm) {
            $total_cm = $total_cm + $cm["cm"];
        }
        $average_cm = number_format(abs($total_cm / count($array_CM)), 4);
        $total_ci = number_format(
            abs(($average_cm - count($kriteria)) / (count($kriteria) - 1)),
            4
        );
        $ratio = [null, 0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45];
        $result = number_format(abs($total_ci / $ratio[count($kriteria)]), 4);

        for ($i = 0; $i < count($kriteria); $i++) {
            Kriteria::where(
                "kode_kriteria",
                $kriteria[$i]->kode_kriteria
            )->update([
                "bobot" => $array_BobotPrioritas[$i]["bobot"],
            ]);
        }

        $data = [
            "kriteria" => $kriteria,
            "matriks_perbandingan" => $matriks_perbandingan,
            "matriks_awal" => $matriks_awal,
            "average_cm" => $average_cm,
            "bobot_prioritas" => $array_BobotPrioritas,
            "matriks_normalisasi" => $array_normalisasi,
            "jumlah" => $array_jumlah,
            "cm" => $array_CM,
            "ci" => $total_ci,
            "result" => $result,
            "total_jumlah_baris" => $total_jumlah_baris,
        ];

        return $data;
    }

    public function bariskolom()
    {
        $kriteria_model = new Kriteria();
        $kriteria = $kriteria_model->getAllKriteria();

        $a = 0;
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = $i; $j < count($kriteria); $j++) {
                $array[$a]["baris"] = $kriteria[$i]->nama;
                $array[$a]["kolom"] = $kriteria[$j]->nama;
                $a++;
            }
        }
        return response()->json($array);
    }

    // public function perbandinganPDF($kode_ahp)
    // {
    //     $hasil = $this->getHasilPerbandingan($kode_ahp);
    //     $kriteria = $hasil["kriteria"];
    //     $ahp = DB::table("ahp")
    //         ->where("kode_ahp", $kode_ahp)
    //         ->get()[0];

    //     $konsistensi = "";
    //     if ($hasil["result"] < 0.1) {
    //         $this->$konsistensi = "Konsisten";
    //     } else {
    //         $this->$konsistensi = "Tidak Konsisten";
    //     }

    //     $pdf = new Fpdf();
    //     $pdf->AddPage("P", "A4");
    //     $pdf->Image("images/lambang_Kota_Tangerang.png", 11, 5, 31, 31);
    //     $pdf->Cell(25);
    //     $pdf->SetTextColor(61, 68, 99);
    //     $pdf->SetFont("Times", "B", "14");
    //     $pdf->Cell(0, 5, "PEMERINTAH KOTA TANGERANG", 0, 1, "C");
    //     $pdf->Cell(25);
    //     $pdf->Cell(0, 5, "DINAS PENDIDIKAN", 0, 1, "C");
    //     $pdf->Cell(25);
    //     $pdf->Cell(0, 5, "UPT SATUAN PENDIDIKAN", 0, 1, "C");
    //     $pdf->Cell(25);
    //     $pdf->Cell(0, 5, "SD NEGERI JURUMUDI 1", 0, 1, "C");
    //     $pdf->Cell(25);
    //     $pdf->SetFont("Times", "B", 9);
    //     // Removes bold
    //     $pdf->SetFont("");
    //     $pdf->Cell(
    //         0,
    //         3,
    //         "Alamat : Jl.Halim Perdana Kusuma, Kel. Jurumudi, Kec. Benda, Konta Tangerang Banten Kode Pos 15124",
    //         0,
    //         1,
    //         "C"
    //     );
    //     $pdf->Cell(25);
    //     $pdf->Cell(0, 3, "Email : sdnjurumudisatu@yahoo.com", 0, 1, "C");

    //     $pdf->SetFont("Times", "B", "12");
    //     $pdf->Cell(
    //         0,
    //         5,
    //         "NSS : 101280504004                                                    TANGERANG",
    //         0,
    //         0,
    //         "L"
    //     );
    //     $pdf->Cell(0, 5, "NPSN : 20606975", 0, 0, "R");

    //     $pdf->SetLineWidth(1);

    //     $pdf->Line(10, 41, 198, 41);
    //     $pdf->SetLineWidth(0);
    //     $pdf->Line(10, 42, 198, 42);
    //     $pdf->Ln(14);
    //     $pdf->SetTextColor(0, 0, 0);
    //     $pdf->SetFont("Times", "U", "14");
    //     $pdf->Cell(0, 5, "HASIL PEMBOBOTAN", 0, 1, "C");
    //     $pdf->SetFont("Times", "", "12");
    //     // $pdf->Cell(0,5,'12345678',0,1,'C');
    //     $pdf->Ln(12);
    //     $pdf->SetFont("Times", "B", "12");
    //     $pdf->Cell(35, 5, "Kode AHP ", 0, 0, "L");
    //     $pdf->SetFont("Times", "", "12");
    //     $pdf->Cell(50, 5, " : " . $ahp->kode_ahp, 0, 1, "L");

    //     $pdf->SetFont("Times", "B", "12");
    //     $pdf->Cell(35, 5, "Hasil Konsistensi ", 0, 0, "L");
    //     $pdf->SetFont("Times", "", "12");
    //     $pdf->Cell(50, 5, " : " . $this->$konsistensi, 0, 1, "L");

    //     $pdf->Ln(7);

    //     $pdf->SetFont("Times", "B", "13");
    //     $pdf->Cell(20, 9, "NO", 1, 0, "C");
    //     $pdf->Cell(58, 9, "Kriteria", 1, 0, "C");
    //     $pdf->Cell(40, 9, "Eigenvector", 1, 1, "C");

    //     $no = 1;

    //     $pdf->SetFont("Times", "", "12");
    //     for ($i = 0; $i < count($kriteria); $i++) {
    //         $pdf->Cell(20, 9, $no++, 1, 0, "C");
    //         $pdf->Cell(58, 9, $hasil["kriteria"][$i]->nama, 1, 0, "C");
    //         $pdf->Cell(
    //             40,
    //             9,
    //             $hasil["bobot_prioritas"][$i]["bobot"],
    //             1,
    //             1,
    //             "C"
    //         );
    //     }

    //     $pdf->Ln(25);
    //     date_default_timezone_set("Asia/Jakarta");
    //     $currentdate = date("d-M-Y");
    //     $pdf->Cell(329, 9, "Tangerang, " . $currentdate, 0, 1, "C");
    //     $pdf->Cell(308, 3, "Mengetahui,", 0, 1, "C");
    //     $pdf->Cell(313, 5, "Kepala Sekolah", 0, 1, "C");

    //     $pdf->SetFont("Times", "BU", "12");
    //     $pdf->Cell(335, 60, "Drs.H.MAHPUJI                ", 0, 1, "C");
    //     $pdf->SetFont("Times", "", "12");
    //     $pdf->Cell(333, -50, "NIP:196306211984101010", 0, 1, "C");
    //     $pdf->Output();
    //     exit();
    // }

    public function destroy()
    {
        DB::table("perbandingan")->delete();
        Kriteria::where("bobot", "!=", null)->update([
            "bobot" => null,
        ]);
        $data = [
            "status" => true,
            "message" => "Perbandingan berhasil direset ",
        ];

        return response()->json($data);
    }

    public function testahp()
    {
        $data = [
            "email" => ["test"],
        ];
        dd($data["email"][0]);
    }
}
