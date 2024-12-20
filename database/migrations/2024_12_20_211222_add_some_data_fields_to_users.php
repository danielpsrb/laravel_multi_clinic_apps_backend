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
        Schema::table('users', function (Blueprint $table) {
            //clinic_id
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->onDelete('set null');
            //specialist_id
            $table->foreignId('specialist_id')->nullable()->constrained('specialists')->onDelete('set null');
            $table->enum('roles', ['admin', 'doctor', 'patient'])->default('patient');
            $table->string('google_id')->nullable();
            $table->string('ktp_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('certification')->nullable();
            $table->integer('telemedicine_fee')->nullable();
            $table->integer('chat_fee')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
