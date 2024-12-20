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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //patient_id
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            //doctor_id
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            //clinic_id
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            $table->string('service');
            $table->integer('price');
            $table->string('payment_url')->nullable();
            $table->enum('status', ['waiting', 'paid', 'cancel'])->default('waiting');
            $table->integer('duration');
            $table->dateTime('schedule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
