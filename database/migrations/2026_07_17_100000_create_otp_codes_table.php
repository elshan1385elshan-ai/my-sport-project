<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->index();
            $table->string('code', 255);
            $table->string('purpose', 20)->default('login'); // login | register
            $table->string('name')->nullable();              // فقط برای ثبت‌نام
            $table->string('email')->nullable();             // فقط برای ثبت‌نام
            $table->string('password')->nullable();          // فقط برای ثبت‌نام
            $table->timestamp('expires_at');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
