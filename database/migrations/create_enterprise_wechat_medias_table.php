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
        Schema::create('medias', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('type')->default('')->comment('文件类型[图片image、语音voice、视频video，普通文件file]');
            $table->string('file_name')->default('')->comment('文件名');
            $table->string('url', 1024)->default('')->comment('图片URL, 永久有效');
            $table->string('media_id')->default('')->comment('文件唯一标识, 3天有效');
            $table->string('media_created_at')->default('')->comment('文件上传日期');
            $table->tinyInteger('upload_mode')->default(0)->comment('上传方式[0同步1异步]');
            $table->tinyInteger('upload_status')->default(0)->comment('上传状态[1处理中 2完成 3异常失败]');
            $table->string('job_id')->default('')->comment('异步任务id');
            $table->integer('scene')->default(0)->comment('场景值');
            $table->string('file_md5', 32)->default('')->comment('文件MD5');
            $table->string('err_msg')->default('')->comment('任务失败描述');
            $table->index(['corp_id', 'job_id'], DB::getTablePrefix().'corp_job_index');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."medias` comment '素材表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
