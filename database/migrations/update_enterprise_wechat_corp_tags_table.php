<?php

declare(strict_types=1);

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
        Schema::table('corp_tags', function (Blueprint $table) {
            $table->bigInteger('group_order')->nullable()->default(0)->comment('标签组排序的次序值')->change();
            $table->bigInteger('order')->nullable()->default(0)->comment('标签排序的次序值')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('corp_tags', function (Blueprint $table) {
            $table->integer('group_order')->nullable()->default(0)->comment('标签组排序的次序值')->change();
            $table->integer('order')->nullable()->default(0)->comment('标签排序的次序值')->change();
        });
    }
};
