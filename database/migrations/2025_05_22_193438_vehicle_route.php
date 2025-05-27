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
          Schema::create('cebu_legacy', function (Blueprint $table) {
            $table->id();
            $table->string('imagepath');
            $table->string('title');
            $table->text('description');
            $table->double(column: 'map_lat')->nullable();
            $table->double(column: 'map_lng')->nullable();
            $table->integer('ispublished')->default(0);
            $table->timestamps();
        });

        Schema::create('vehicle_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cebu_legacy_id');
            $table->foreign('cebu_legacy_id')->references('id')->on('cebu_legacy');
            $table->string('route_name');
            $table->string('vehicle_code')->nullable();
            $table->float('price')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('vehicle_route');
        Schema::dropIfExists('cebu_legacy');
       
    }
};
