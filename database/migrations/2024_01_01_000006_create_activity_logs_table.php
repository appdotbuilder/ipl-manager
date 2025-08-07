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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action')->comment('Action performed');
            $table->string('entity_type')->comment('Type of entity affected');
            $table->unsignedBigInteger('entity_id')->nullable()->comment('ID of entity affected');
            $table->json('old_values')->nullable()->comment('Previous values');
            $table->json('new_values')->nullable()->comment('New values');
            $table->string('ip_address')->nullable()->comment('User IP address');
            $table->text('user_agent')->nullable()->comment('User agent');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('entity_type');
            $table->index('entity_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};