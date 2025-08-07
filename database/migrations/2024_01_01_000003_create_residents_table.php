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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nama_warga')->comment('Resident name');
            $table->string('blok_nomor_rumah')->comment('Block and house number (e.g., D1/No.1)');
            $table->decimal('default_nominal_ipl', 12, 2)->default(90000)->comment('Default IPL amount');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('nama_warga');
            $table->index('blok_nomor_rumah');
            $table->unique('blok_nomor_rumah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};