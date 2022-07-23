<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("hasil", function (Blueprint $table) {
            $table
                ->string("kode_hasil", 10)
                ->primary()
                ->unique();
            $table->integer("periode");
            $table->double("nilai_saw", 5, 4);
            $table->string("keterangan", 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("hasil");
    }
}
