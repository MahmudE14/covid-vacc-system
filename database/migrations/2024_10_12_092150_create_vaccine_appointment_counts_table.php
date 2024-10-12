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
        Schema::create('vaccine_appointment_counts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->foreignId('vaccine_center_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('appointments_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_appointment_counts');
    }
};
