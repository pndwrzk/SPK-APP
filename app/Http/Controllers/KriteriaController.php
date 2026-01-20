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

  
}
