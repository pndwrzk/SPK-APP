<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\RedisHandler;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthController extends Controller
{
    public function index()
    {
        if (session("kode_user_login")) {
            return redirect("/dashboard");
        } else {
            return view("auth.Login");
        }
    }
    public function registrasi()
    {
        if (session("kode_user_login")) {
            return redirect("/dashboard");
        } else {
            return view("auth.registrasi");
        }
    }

    public function store(Request $request)
    {
        $user = new User();
        $kode_user = $user->getAutoKodeUser();

        $validation = Validator::make($request->all(), [
            "nama" => "required",
            "telepon" => "required|min:10|numeric",
            "email" => "required|email|unique:users",
            "password" => "required|same:password_ulang|min:3",
            "password_ulang" => "required",
        ]);

        if ($validation->fails()) {
            return redirect("/registrasi")
                ->withErrors($validation)
                ->withInput();
        }

        $user->kode_user = $kode_user;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->telepon = $request->telepon;

        $user->password = Hash::make($request->password);
        $user->save();

        $data = [
            "status" => true,
            "message" => "Data user berhasil ditambahkan",
        ];
        return redirect("/login")->with("success", "Akun Berhasil dibuat");
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (
            Auth::attempt([
                "email" => $request->email,
                "password" => $request->password,
            ])
        ) {
            $user = DB::table("users")
                ->where("email", $request->email)
                ->first();

            session()->push("kode_user_login", $user->kode_user);

            return redirect("/dashboard");
        } else {
            return redirect()
                ->back()
                ->with("failed", "email atau password salah");
        }
    }

    public function show($kode)
    {
        $user = DB::table("users")
            ->where("kode_user", $kode)
            ->first();
        return $user;
    }

    public function update(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            "nama" => "required",
            "telepon" => "required",
            "email" => "required",
        ]);

        if ($credentials->fails()) {
            $data = [
                "status" => false,
                "message" => $credentials->errors(),
            ];
            return response()->json($data, 422);
        } else {
            $user = DB::table("users")
                ->where("email", $request->email)
                ->first();

            if ($user) {
                if ($user->kode_user !== $request->kode_user) {
                    $data = [
                        "status" => false,
                        "message" => [
                            "email" => ["Email Sudah Terdaftar"],
                        ],
                    ];
                    return response()->json($data, 422);
                }
            }

            DB::table("users")
                ->where("kode_user", $request->kode_user)
                ->update([
                    "email" => $request->email,
                    "telepon" => $request->telepon,
                    "nama" => $request->nama,
                ]);

            $data = [
                "status" => true,
                "message" => "Data profile berhasil diperbarui",
            ];
            return response()->json($data, 200);
        }
    }

    public function ubahpassword(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            "password" => "required",
            "passwordBaru" => "required|same:ulangPasswordBaru",
            "ulangPasswordBaru" => "required",
        ]);

        if ($credentials->fails()) {
            $data = [
                "status" => false,
                "message" => $credentials->errors(),
            ];
            return response()->json($data, 422);
        }

        $user = DB::table("users")
            ->where("kode_user", $request->kode_user)
            ->first();

        if (
            Auth::attempt([
                "email" => $user->email,
                "password" => $request->password,
            ])
        ) {
            DB::table("users")
                ->where("kode_user", $request->kode_user)
                ->update(["password" => Hash::make($request->passwordBaru)]);

            $data = [
                "status" => true,
                "message" => "Password berhasil diperbarui",
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                "status" => false,
                "failed" => "Password yang anda masukkan salah",
            ];
            return response()->json($data, 422);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect("/login");
    }

    public function dashboard()
    {
        $hasil = DB::table("hasil")
            ->groupBy("periode")
            ->get();
        $kriteria = DB::table("kriteria")->get();
        $guru = DB::table("guru")->get();

        $path = storage_path() . "/app/artikel.json";
        $artikel = json_decode(file_get_contents($path), true);

        $data = [
            "guru" => count($guru),
            "kriteria" => count($kriteria),

            "hasil" => count($hasil),
            "artikel" => $artikel,
        ];

        return $data;
    }

    public function destroy($kode)
    {
        DB::table("users")
            ->where("kode_user", $kode)
            ->delete();

        $data = [
            "status" => true,
            "message" => "Data user berhasil dihapus",
        ];
        return response()->json($data, 200);
    }
}
