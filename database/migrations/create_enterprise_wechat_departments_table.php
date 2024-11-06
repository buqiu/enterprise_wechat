<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->bigInteger('department_id')->nullable()->default(0)->comment('企微部门ID');
            $table->bigInteger('parent_id')->nullable()->default(0)->comment('父部门ID');
            $table->json('path')->nullable()->comment('上级-末级路径');
            $table->string('name')->nullable()->default('')->comment('部门名称');
            $table->string('name_en')->nullable()->default('')->comment('部门名称');
            $table->json('department_leader')->nullable()->comment('部门负责人的 UserID');
            $table->integer('order')->nullable()->default(0)->comment('在父部门中的次序值');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'department_id'], DB::getTablePrefix().'corp_department_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."departments` comment '部门表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
