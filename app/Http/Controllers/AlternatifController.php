<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Alternatif = Alternatif::all();
        return response()->json($Alternatif);
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
            "tempat_lahir" => "required",
            "nip" => "required",
            "jenis_kelamin" => "required",
            "tanggal_lahir" => "required",
        ]);

        if ($validation->fails()):
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        else:
            $alternatif = new Alternatif();
            $kode_alternatif = $alternatif->getAutoKodeAlternatif();

            $alternatif->kode_guru = $kode_alternatif;
            $alternatif->nama = $request->nama;
            $alternatif->jenis_kelamin = $request->jenis_kelamin;
            $alternatif->nip = $request->nip;
            $alternatif->tanggal_lahir = $request->tanggal_lahir;
            $alternatif->tempat_lahir = $request->tempat_lahir;
            $alternatif->save();

            $data = [
                "status" => true,
                "message" => "Data Guru berhasil ditambahkan",
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
        $alternatif = DB::table("guru")
            ->where("kode_guru", $kode)
            ->first();

        $data = [
            "kode_guru" => $alternatif->kode_guru,
            "nip" => $alternatif->nip,
            "nama" => $alternatif->nama,
            "jenis_kelamin" => $alternatif->jenis_kelamin,
            "tempat_lahir" => $alternatif->tempat_lahir,
            "tanggal_lahir" =>
                date("d", strtotime($alternatif->tanggal_lahir)) .
                "-" .
                getBulan(date("m", strtotime($alternatif->tanggal_lahir))) .
                "-" .
                date("Y", strtotime($alternatif->tanggal_lahir)),
        ];
        return response()->json($data);
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

    public function update(Request $request, $kode)
    {
        $validation = Validator::make($request->all(), [
            "nama" => "required",
            "tempat_lahir" => "required",
            "nip" => "required",
            "jenis_kelamin" => "required",
            "tanggal_lahir" => "required",
        ]);

        if ($validation->fails()):
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        else:
            Alternatif::where("kode_guru", $kode)->update([
                "nama" => $request->nama,
                "tempat_lahir" => $request->tempat_lahir,
                "jenis_kelamin" => $request->jenis_kelamin,
                "nip" => $request->nip,
                "tanggal_lahir" => $request->tanggal_lahir,
            ]);

            $data = [
                "status" => true,
                "message" => "Data Guru berhasil diperbarui",
            ];
            return response()->json($data, 200);
        endif;
    }

    public function destroy($kode)
    {
        $guru = DB::table("penilaian")
            ->where("kode_guru", $kode)
            ->get();
        if (count($guru) != 0) {
            $data = [
                "status" => true,
                "message" =>
                    "Data Guru Gagal dihapus, Karena Sudah Terdaftar Dalam Penilaian",
            ];

            return response()->json($data, 422);
        } else {
            DB::table("guru")
                ->where("kode_guru", $kode)
                ->delete();
            $data = [
                "status" => true,
                "message" => "Data Guru berhasil dihapus",
            ];

            return response()->json($data, 200);
        }
    }

    // public function exportPDF()
    // {
    //     $alternatif = Alternatif::all();
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
    //     $pdf->Cell(0, 7, "LAPORAN DAFTAR GURU", 0, 1, "C");
    //     $pdf->Ln(15);

    //     $pdf->SetFont("Times", "B", "12");
    //     $pdf->Cell(10, 9, "NO", 1, 0, "C");
    //     $pdf->Cell(50, 9, "NIP", 1, 0, "C");
    //     $pdf->Cell(40, 9, "Nama", 1, 0, "C");
    //     $pdf->Cell(30, 9, "Jenis Kelamin", 1, 0, "C");
    //     $pdf->Cell(30, 9, "Tempat Lahir", 1, 0, "C");
    //     $pdf->Cell(30, 9, "Tanggal Lahir", 1, 1, "C");

    //     $no = 1;
    //     $pdf->SetFont("Times", "", "11");
    //     foreach ($alternatif as $a) {
    //         $pdf->Cell(10, 9, $no++, 1, 0, "C");
    //         $pdf->Cell(50, 9, $a->nip, 1, 0, "C");
    //         $pdf->Cell(40, 9, $a->nama, 1, 0, "C");
    //         $pdf->Cell(30, 9, $a->jenis_kelamin, 1, 0, "C");
    //         $pdf->Cell(30, 9, $a->tempat_lahir, 1, 0, "C");
    //         $pdf->Cell(
    //             30,
    //             9,
    //             date("d-m-Y", strtotime($a->tanggal_lahir)),
    //             1,
    //             1,
    //             "C"
    //         );
    //     }

    //     $pdf->Ln(30);
    //     date_default_timezone_set("Asia/Jakarta");
    //     $currentdate = date("d-M-Y");
    //     $pdf->Cell(327, 9, "Tangerang, " . $currentdate, 0, 1, "C");
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
