<?php

namespace App\Http\Controllers;

use App\Models\Saw;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Perbandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $path = storage_path() . "/app/artikel.json";
        $artikel = json_decode(file_get_contents($path), true);

        return $artikel;
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "nama" => "required",
            "tanggal" => "required",
            "artikel" => "required",
            "link" => "required",
            "judul" => "required",
            "pengunggah" => "required",
        ]);

        if ($validation->fails()):
            $data = [
                "status" => false,
                "message" => $validation->errors(),
            ];
            return response()->json($data, 422);
        else:
            $path = storage_path() . "/app/artikel.json";
            $artikel = json_decode(file_get_contents($path), true);
            $max = 0;
            if ($artikel) {
                for ($i = 0; $i < count($artikel); $i++) {
                    if ($artikel[$i]["kode"] > $max) {
                        $max = $artikel[$i]["kode"];
                    }
                }
                $kode = $max + 1;
            } else {
                $kode = 1;
            }
            $artikel[] = [
                "kode" => $kode,
                "penerbit" => $request->nama,
                "pengunggah" => $request->pengunggah,
                "tanggal_terbit" => $request->tanggal,
                "link" => $request->link,
                "judul" => $request->judul,
                "konten" => $request->artikel,
            ];

            Storage::disk("local")->put(
                "artikel.json",
                json_encode($artikel, JSON_PRETTY_PRINT)
            );

            $data = [
                "status" => true,
                "message" => "Data Artikel berhasil ditambahkan",
            ];
            return response()->json($data, 200);
        endif;
    }

    public function destroy($kode)
    {
        $path = storage_path() . "/app/artikel.json";
        $artikel = json_decode(file_get_contents($path), true);
        for ($i = 0; $i < count($artikel); $i++) {
            if ($artikel[$i]["kode"] == $kode) {
                array_splice($artikel, $i, $i);
                Storage::disk("local")->put(
                    "artikel.json",
                    json_encode($artikel, JSON_PRETTY_PRINT)
                );
            }
        }

        $data = [
            "status" => true,
            "message" => "Data Artikel berhasil dihapus",
        ];
        return response()->json($data, 200);
    }

    public function show($kode)
    {
        $path = storage_path() . "/app/artikel.json";
        $artikel = json_decode(file_get_contents($path), true);
        for ($i = 0; $i < count($artikel); $i++) {
            if ($artikel[$i]["kode"] == $kode) {
                $data = $artikel[$i];
            }
        }

        return $data;
    }

    public function update(Request $request, $kode)
    {
        $path = storage_path() . "/app/artikel.json";
        $artikel = json_decode(file_get_contents($path), true);
        for ($i = 0; $i < count($artikel); $i++) {
            if ($artikel[$i]["kode"] == $kode) {
                $artikel[$i]["judul"] = $request->judul;
                $artikel[$i]["konten"] = $request->artikel;
                $artikel[$i]["penerbit"] = $request->nama;
                $artikel[$i]["link"] = $request->link;
                $artikel[$i]["tanggal_terbit"] = $request->tanggal;
            }
        }
        Storage::disk("local")->put(
            "artikel.json",
            json_encode($artikel, JSON_PRETTY_PRINT)
        );
        $data = [
            "status" => true,
            "message" => "Data Artikel berhasil diperbarui",
        ];
        return response()->json($data, 200);
    }
}
