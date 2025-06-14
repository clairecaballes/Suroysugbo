<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_site', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cebu_legacy_id');
            $table->foreign('cebu_legacy_id')->references('id')->on('cebu_legacy');
            $table->string('imagepath');
            $table->string('title');
            $table->integer('ispublished')->default(0);
            $table->timestamps();
        });

        //remove column from cebu_legacy
        Schema::table('cebu_legacy', function (Blueprint $table) {
            $table->dropColumn(['map_lat', 'map_lng']);
            $table->string('coordinates')->nullable()->after('description');
        });

        


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_site');
        Schema::table('cebu_legacy', function (Blueprint $table) {
            $table->double('map_lat')->nullable()->after('description');
            $table->double('map_lng')->nullable()->after('map_lat');
            $table->dropColumn('coordinates');
        });
    }
};
