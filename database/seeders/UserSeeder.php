<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {    
          
         DB::table('users')->insert(
             [
        	'kode_user' => 'ADM001',
        	'nama' => 'Super User',
        	'email' => 'superuser@spk.com',
        	'password' => bcrypt('superuser'),
            'kode_role'=> 1,
            'telepon'=> '085890026519',
        ]);
    }

}