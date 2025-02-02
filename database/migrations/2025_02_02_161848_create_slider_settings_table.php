<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('slider_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('autoplay')->default(true);
            $table->integer('speed')->default(300);
            $table->boolean('loop')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_settings');
    }
};
