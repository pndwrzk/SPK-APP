<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SuratKeputusanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

route::post("/ubahpassword", [AuthController::class, "ubahpassword"]);
route::post("/authenticate", [AuthController::class, "authenticate"]);
route::get("/users", [AuthController::class, "getusers"]);
route::get("/user/{kode}", [AuthController::class, "show"]);
route::put("/user", [AuthController::class, "update"]);
route::post("/user", [AuthController::class, "store"]);
route::delete("/user/{kode}", [AuthController::class, "destroy"]);

route::get("/data-dashboard", [AuthController::class, "dashboard"]);
route::get("/alternatif", [AlternatifController::class, "index"]);
route::post("/alternatif", [AlternatifController::class, "store"]);
route::put("/alternatif/{kode}", [AlternatifController::class, "update"]);
route::get("/alternatif/{kode}", [AlternatifController::class, "show"]);
route::delete("/alternatif/{kode}", [AlternatifController::class, "destroy"]);

route::get("/kriteria", [KriteriaController::class, "index"]);
route::post("/kriteria", [KriteriaController::class, "store"]);
route::get("/kriteria/{kode}", [KriteriaController::class, "show"]);
route::put("/kriteria/{kode}", [KriteriaController::class, "update"]);
route::delete("/kriteria/{kode}", [KriteriaController::class, "destroy"]);

route::get("/kriteria-bariskolom", [
    PerbandinganController::class,
    "bariskolom",
]);
route::post("/simpan-perbandingan", [
    PerbandinganController::class,
    "simpan_perbandingan",
]);
route::get("/perbandingan-kriteria", [PerbandinganController::class, "index"]);
route::get("/hasil-perbandingan", [
    PerbandinganController::class,
    "getHasilPerbandingan",
]);

route::delete("/hasil-perbandingan", [
    PerbandinganController::class,
    "destroy",
]);

route::get("/penilaian", [PenilaianController::class, "index"]);
route::get("/hasil-akhir/{periode}", [PenilaianController::class, "show"]);
route::get("/get-column-matriks", [
    PenilaianController::class,
    "columnMatriks",
]);
route::post("/simpan-matriks", [PenilaianController::class, "store"]);
route::get("/hasil-penilaian/{periode}", [
    PenilaianController::class,
    "getHasilPenilaian",
]);
route::delete("/penilaian/{periode}", [PenilaianController::class, "destroy"]);

route::post("/artikel", [ArtikelController::class, "store"]);
route::get("/artikel", [ArtikelController::class, "index"]);
route::delete("/artikel/{kode}", [ArtikelController::class, "destroy"]);
route::get("/artikel/{kode}", [ArtikelController::class, "show"]);

route::post("/artikel", [ArtikelController::class, "store"]);
route::put("/artikel/{kode}", [ArtikelController::class, "update"]);
route::get("/surat-keputusan/", [SuratKeputusanController::class, "index"]);
route::get("/surat-keputusan/{kode_hasil}", [
    SuratKeputusanController::class,
    "show",
]);
route::delete("/surat-keputusan/{kode_sk}", [
    SuratKeputusanController::class,
    "destroy",
]);
