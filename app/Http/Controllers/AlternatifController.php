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
            "tanggal_lahir" => $alternatif->tanggal_lahir,
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

    
}
