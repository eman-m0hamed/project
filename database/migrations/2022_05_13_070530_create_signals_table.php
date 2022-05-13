<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id');
            $table->enum('type', ['EEG', 'EMG'])->nullable()->default(['EEG', 'EMG']);
            $table->string('classification');
            $table->float('prop_of_seiz');
            $table->float('prop_of_non_seiz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signals');
    }
}
