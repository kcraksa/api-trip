<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->dateTime('start_date', $precision = 0);
            $table->dateTime('end_date', $precision = 0);
            $table->unsignedBigInteger('trip_types_id')->nullable();
            $table->text('description');
            $table->timestamps();
        });

        Schema::table('trips', function (Blueprint $table)
        {
            $table->foreign('origin_id')->references('id')->on('cities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('destination_id')->references('id')->on('cities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('trip_types_id')->references('id')->on('trip_types')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
