<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            
            $table->text('description')->nullable();
            
            $table->decimal('price', 12, 2);
            $table->decimal('old_price', 12, 2)->nullable();
            
            $table->string('image')->nullable();           // تصویر اصلی
            $table->json('images')->nullable();            // گالری تصاویر (چند عکس)
            
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            
            // فیلدهای اضافی برای فروشگاه ورزشی
            $table->string('category')->nullable();        // مثلاً: جرسی، کفش، توپ، لوازم تمرینی
            $table->string('sport_type')->nullable();      // فوتبال، بسکتبال، والیبال و...
            $table->string('player_name')->nullable();     // مثلاً: مسی، رونالدو
            
            $table->timestamps();
            
            // ایندکس برای جستجوی سریع
            $table->index('name');
            $table->index('brand');
            $table->index('category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};