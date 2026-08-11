<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // انتقال داده‌های موجود از ستون category_id به جدول واسط
        $rows = DB::table('products')
            ->whereNotNull('category_id')
            ->select('id', 'category_id')
            ->get();

        foreach ($rows as $row) {
            DB::table('category_product')->insert([
                'category_id' => $row->category_id,
                'product_id' => $row->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('discount')
                    ->constrained('categories')
                    ->onDelete('set null');
            }
        });

        $rows = DB::table('category_product')->get();
        foreach ($rows as $row) {
            DB::table('products')
                ->where('id', $row->product_id)
                ->update(['category_id' => $row->category_id]);
        }

        Schema::dropIfExists('category_product');
    }
};
