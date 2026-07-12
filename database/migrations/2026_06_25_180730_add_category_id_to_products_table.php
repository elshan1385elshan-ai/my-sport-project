<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // اضافه کردن ستون درست
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('discount')
                  ->constrained('categories')
                  ->onDelete('set null');

            // اختیاری: ستون قدیمی category را می‌توانید نگه دارید یا بعداً حذف کنید
            // $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};