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
            $table->string('description');
            $table->int('ispublished')->default(0);
            $table->timestamps();
        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cebu_legacy');
    }
};
