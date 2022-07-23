<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\SuratKeputusanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return redirect("/dashboard");
});

route::get("/registrasi", [AuthController::class, "registrasi"]);
route::post("/registrasi", [AuthController::class, "store"]);
route::get("/logout", [AuthController::class, "logout"]);
route::post("/login", [AuthController::class, "authenticate"]);
route::get("/login", [AuthController::class, "index"]);
route::get("/test", [PerbandinganController::class, "testahp"]);
route::get("/laporan-perangkingan/{periode}/export-pdf", [
    PenilaianController::class,
    "cetak_laporan_perangkingan",
]);

route::get("/surat-keputusan/{kode_hasil}/buat-keputusan", [
    PenilaianController::class,
    "buat_keputusan",
]);
route::get("/laporan-hasil-keputusan/export-pdf", [
    SuratKeputusanController::class,
    "cetak_laporan_sk",
]);
route::get("/surat-keputusan/{kode_hasil}/export-pdf", [
    SuratKeputusanController::class,
    "cetak_surat_keputusan",
]);

route::get("/laporan-penilaian/{periode}/export-pdf", [
    PenilaianController::class,
    "cetak_laporan_penilaian",
]);

Route::get("/{any}", function () {
    if (session("kode_user_login")) {
        return view("Index");
    } else {
        return redirect("/login");
    }
})->where("any", ".*");
