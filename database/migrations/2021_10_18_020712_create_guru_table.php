<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("guru", function (Blueprint $table) {
            $table
                ->string("kode_guru", 10)
                ->primary()
                ->unique();
            $table->string("nama", 100);
            $table->string("nip", 30)->unique();
            $table->string("jenis_kelamin", 10);
            $table->string("tempat_lahir", 50);
            $table->date("tanggal_lahir");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("guru");
    }
}
