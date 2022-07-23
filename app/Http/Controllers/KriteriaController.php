<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PDF;
use Codedge\Fpdf\Fpdf\Fpdf;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $fpdf;
    public function index()
    {
        $kriteria = Kriteria::all();
        return $kriteria;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "nama" => "required",
            "atribut" => "required",
        ]);

        if ($validation->fails()):
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        else:
            $Kriteria = new Kriteria();
            $kode_kriteria = IdGenerator::generate([
                "table" => "kriteria",
                "field" => "kode_kriteria",
                "length" => 6,
                "prefix" => "KRT",
            ]);

            $Kriteria->kode_kriteria = $kode_kriteria;
            $Kriteria->nama = $request->nama;
            $Kriteria->bobot = $request->bobot;
            $Kriteria->atribut = $request->atribut;
            $Kriteria->save();

            $data = [
                "status" => true,
                "message" => "Data kriteria berhasil ditambahkan",
            ];
            return response()->json($data, 200);
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kode)
    {
        $kriteria = DB::table("kriteria")
            ->where("kode_kriteria", $kode)
            ->first();
        return response()->json($kriteria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode)
    {
        $validation = Validator::make($request->all(), [
            "nama" => "required",
            "atribut" => "required",
        ]);

        if ($validation->fails()):
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        else:
            Kriteria::where("kode_kriteria", $kode)->update([
                "nama" => $request->nama,
                "bobot" => $request->bobot,
                "atribut" => $request->atribut,
            ]);

            $data = [
                "status" => true,
                "message" => "Data kriteria berhasil diperbarui",
            ];
            return response()->json($data, 200);
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode)
    {
        $kriteria = DB::table("penilaian")
            ->where("kode_kriteria", $kode)
            ->get();
        if (count($kriteria) != 0) {
            $data = [
                "status" => true,
                "message" =>
                    "Data Kriteria Gagal dihapus, Karena Sudah Terdaftar Dalam Penilaian",
            ];

            return response()->json($data, 422);
        } else {
            DB::table("kriteria")
                ->where("kode_kriteria", $kode)
                ->delete();
            $data = [
                "status" => true,
                "message" => "Data Kriteria berhasil dihapus",
            ];

            return response()->json($data, 200);
        }
    }

    // public function exportPDF()
    // {
    //     $kriteria = Kriteria::all();
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
    //     $pdf->Cell(15);
    //     $pdf->Cell(0, 5, "LAPORAN DAFTAR KRITERIA", 0, 1, "C");
    //     $pdf->Ln(15);

    //     $pdf->SetFont("Times", "B", "13");
    //     $pdf->Cell(20, 9, "No", 1, 0, "C");
    //     $pdf->Cell(40, 9, "kode", 1, 0, "C");
    //     $pdf->Cell(58, 9, "Nama", 1, 0, "C");
    //     $pdf->Cell(30, 9, "Atribut", 1, 0, "C");
    //     $pdf->Cell(40, 9, "Bobot", 1, 1, "C");
    //     $no = 1;
    //     $pdf->SetFont("Times", "", "12");
    //     foreach ($kriteria as $k) {
    //         $pdf->Cell(20, 9, $no++, 1, 0, "C");
    //         $pdf->Cell(40, 9, $k->kode_kriteria, 1, 0, "C");
    //         $pdf->Cell(58, 9, $k->nama, 1, 0, "C");
    //         $pdf->Cell(30, 9, $k->atribut, 1, 0, "C");
    //         if ($k->bobot == null) {
    //             $pdf->Cell(40, 9, "-", 1, 1, "C");
    //         } else {
    //             $pdf->Cell(40, 9, $k->bobot, 1, 1, "C");
    //         }
    //     }

    //     $pdf->Ln(30);
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
}
