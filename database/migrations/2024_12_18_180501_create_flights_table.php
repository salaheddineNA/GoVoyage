<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('from_city');
            $table->string('to_city');
            $table->string('airline');
            $table->string('imageAirline');
            $table->string('cityimg');
            $table->float('oldprice');
            $table->float('newprice')->nullable();
            $table->float('percentage')->nullable();
            $table->DateTime('departing_time');
            $table->DateTime('arriving_time');
            $table->string('duration');
            $table->boolean('has_wifi');
            $table->boolean('is_direct');
            $table->boolean('is_offer');
            $table->boolean('showcase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
