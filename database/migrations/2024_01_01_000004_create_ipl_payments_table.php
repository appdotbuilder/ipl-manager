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
        Schema::create('ipl_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor')->comment('Sequential number');
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->decimal('nominal_ipl', 12, 2)->comment('IPL payment amount');
            $table->year('tahun_periode')->comment('IPL year period');
            $table->enum('bulan_ipl', [
                'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
            ])->comment('IPL month');
            $table->enum('status_pembayaran', ['paid', 'unpaid', 'exempt'])->default('unpaid')->comment('Payment status');
            $table->boolean('rumah_kosong')->default(false)->comment('Empty house/same owner/exempt from IPL');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['resident_id', 'tahun_periode', 'bulan_ipl']);
            $table->index('status_pembayaran');
            $table->index('tahun_periode');
            $table->index('bulan_ipl');
            $table->index('nomor');
            
            // Prevent duplicate entries
            $table->unique(['resident_id', 'tahun_periode', 'bulan_ipl'], 'unique_ipl_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipl_payments');
    }
};