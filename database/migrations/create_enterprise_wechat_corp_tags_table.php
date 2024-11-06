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
        Schema::create('corp_tags', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('group_id')->nullable()->default('')->comment('标签组id');
            $table->string('group_name')->nullable()->default('')->comment('标签组名称');
            $table->bigInteger('group_create_time')->nullable()->default(0)->comment('标签组创建时间');
            $table->integer('group_order')->nullable()->default(0)->comment('标签组排序的次序值');
            $table->string('tag_id')->nullable()->default('')->comment('标签id');
            $table->string('name')->nullable()->comment('标签名称');
            $table->bigInteger('create_time')->default(0)->nullable()->comment('标签创建时间');
            $table->integer('order')->nullable()->default(0)->comment('标签排序的次序值');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'group_id', 'tag_id'], DB::getTablePrefix().'corp_group_tag_unique');
            $table->index(['corp_id', 'group_name'], DB::getTablePrefix().'corp_group_name_index');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."corp_tags` comment '企业标签表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corp_tags');
    }
};
