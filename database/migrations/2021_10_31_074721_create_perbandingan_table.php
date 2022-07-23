<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbandinganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("perbandingan", function (Blueprint $table) {
            $table
                ->string("kode_perbandingan", 10)
                ->primary()
                ->unique();
            $table->string("kode_kriteria1", 10);
            $table->string("kode_kriteria2", 10);
            $table->decimal("nilai", 8.2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("perbandingan");
    }
}
