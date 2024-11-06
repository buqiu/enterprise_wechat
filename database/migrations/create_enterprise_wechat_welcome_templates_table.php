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
        Schema::create('welcome_templates', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('template_id')->nullable()->default('')->comment('欢迎语素材id');
            $table->json('text')->nullable()->comment('文本消息');
            $table->json('image')->nullable()->comment('图片消息');
            $table->json('link')->nullable()->comment('图文消息');
            $table->json('mini_program')->nullable()->comment('小程序消息');
            $table->json('file')->nullable()->comment('文件消息');
            $table->json('video')->nullable()->comment('视频媒体文件');
            $table->tinyInteger('notify')->nullable()->default(0)->comment('是否通知[0-不通知1-通知]');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'template_id'], DB::getTablePrefix().'corp_template_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."welcome_templates` comment '欢迎语素材表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_templates');
    }
};
