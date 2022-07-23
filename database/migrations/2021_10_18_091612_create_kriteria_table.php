<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("kriteria", function (Blueprint $table) {
            $table
                ->string("kode_kriteria", 10)
                ->primary()
                ->unique();
            $table->string("nama", 50);
            $table->string("bobot", 10);
            $table->string("atribut", 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("kriteria");
    }
}
