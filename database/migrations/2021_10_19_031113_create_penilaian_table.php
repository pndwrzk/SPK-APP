<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("penilaian", function (Blueprint $table) {
            $table
                ->string("kode_penilaian", 10)
                ->primary()
                ->unique();
            $table->string("kode_guru", 10);
            $table->string("kode_kriteria", 10);
            $table->string("kode_hasil", 10);
            $table->integer("nilai");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("penilaian");
    }
}
