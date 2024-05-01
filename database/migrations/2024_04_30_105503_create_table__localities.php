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
        Schema::create('localities', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->integer('postal_code');
            $table->string('city', 60);
            $table->string('province');
            $table->string('country', 60)->nullable();
            $table->string('adress')->nullable();
            $table->integer('population');
            $table->longText('description');
            $table->string('language');
            $table->string('googleplace_id')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localities');
    }
};
