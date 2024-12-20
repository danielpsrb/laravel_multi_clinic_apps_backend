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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->time('open_time');
            $table->time('close_time');
            $table->string('website')->nullable();
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->string('spesialis')->nullable();
            $table->decimal('clinic_latitude', 10, 8)->nullable();
            $table->decimal('clinic_longitude', 11, 8)->nullable();
            $table->enum('operational_status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->string('contact_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
