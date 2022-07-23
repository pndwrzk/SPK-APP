<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeputusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("surat_keputusan", function (Blueprint $table) {
            $table
                ->string("kode_suratkeputusan", 10)
                ->primary()
                ->unique();
            $table->string("kode_hasil", 10);
            $table->date("tanggal");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("surat_keputusan");
    }
}
