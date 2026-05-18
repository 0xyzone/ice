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
        Schema::table('user_legal_infos', function (Blueprint $table) {
            $table->date('citizenship_issued_date')->nullable();
            $table->string('citizenship_issued_place')->nullable();

            $table->string('passport_number')->nullable();
            $table->string('passport_image')->nullable();
            $table->date('passport_issued_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_issued_place')->nullable();

            $table->string('nid_number')->nullable();
            $table->string('nid_image')->nullable();
            $table->date('nid_issued_date')->nullable();
            $table->string('nid_issued_place')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_legal_infos', function (Blueprint $table) {
            $table->dropColumn([
                'citizenship_issued_date',
                'citizenship_issued_place',
                'passport_number',
                'passport_image',
                'passport_issued_date',
                'passport_expiry_date',
                'passport_issued_place',
                'nid_number',
                'nid_image',
                'nid_issued_date',
                'nid_issued_place',
            ]);
        });
    }
};
