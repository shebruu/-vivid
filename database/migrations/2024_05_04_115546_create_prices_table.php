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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2);
            $table->string('age_rang')->nullable();
            $table->string('status')->nullable();
            $table->string('season')->nullable();
            $table->string('day_type')->nullable();
            //   $table->timestamps();

            // Foreign key constraint

            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade')->onUpdate('cascade');


            $table->foreignId('place_id')->constrained('places')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
