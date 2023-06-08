<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScannedBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanned_barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->date('date');
            $table->time('time');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('section');
            $table->string('year_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scanned_barcodes');
    }
}
