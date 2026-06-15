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
        Schema::create('sports', function (Blueprint $table) {
            $table->id(); // شناسه اصلی (ID)
            $table->string('name')->unique(); // نام محصول (با قابلیت منحصر به فرد بودن)
            $table->decimal('price', 15, 2); // قیمت (با دقت اعشار برای مبالغ بالا)
            $table->decimal('discount', 15, 2)->default(0); // تخفیف (پیش‌فرض صفر)
            $table->string('image'); // مسیر ذخیره شده عکس در پوشه storage
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // ایجاد ستون‌های created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
