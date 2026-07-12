<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_seller')->default(false)->after('role');
            $table->string('shop_name')->nullable()->after('is_seller');
            $table->text('shop_description')->nullable()->after('shop_name');
            $table->string('shop_slug')->nullable()->unique()->after('shop_description');
            $table->string('shop_logo')->nullable()->after('shop_slug');
            $table->json('shop_social')->nullable()->after('shop_logo');
            $table->timestamp('seller_verified_at')->nullable()->after('shop_social');
            $table->enum('seller_status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending')->after('seller_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_seller', 'shop_name', 'shop_description', 'shop_slug',
                'shop_logo', 'shop_social', 'seller_verified_at', 'seller_status'
            ]);
        });
    }
};