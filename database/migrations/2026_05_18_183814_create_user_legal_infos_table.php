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
        Schema::create('user_legal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('citizenship_number')->nullable();
            $table->string('citizenship_front_image')->nullable();
            $table->string('citizenship_back_image')->nullable();

            $table->string('pan_number')->nullable();
            $table->string('pan_image')->nullable();

            $table->string('ssf_number')->nullable();
            $table->string('ssf_image')->nullable();

            $table->string('driving_license_number')->nullable();
            $table->string('driving_license_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_legal_infos');
    }
};
