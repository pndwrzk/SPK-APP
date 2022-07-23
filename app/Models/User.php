<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["kode_user", "nama", "email", "password", "telepon"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    public function getAutoKodeUser()
    {
        $users = DB::select(
            "select RIGHT(kode_user,3) as kode from users ORDER BY kode_user DESC  LIMIT 1"
        );
        if ($users) {
            $kode = intval($users[0]->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodejadi = "ADM" . $kodemax;
        return $kodejadi;
    }
}
