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
        Schema::create('moments', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('job_id')->nullable()->default('')->comment('异步任务id');
            $table->string('moment_id')->nullable()->default('')->comment('朋友圈id');
            $table->tinyInteger('status')->nullable()->default(0)->comment('任务状态 1表示开始创建任务 2表示正在创建任务中 3表示创建任务已完成');
            $table->json('text')->nullable()->comment('文本消息');
            $table->json('attachments')->nullable()->comment('附件');
            $table->json('visible_range')->nullable()->comment('指定的发表范围');
            $table->json('invalid_sender_list')->nullable()->comment('不合法的执行者列表');
            $table->json('invalid_external_contact_list')->nullable()->comment('不合法的客户列表');
            $table->json('task_list')->nullable()->comment('发表任务列表');
            $table->json('customer_list')->nullable()->comment('成员可见客户列表');
            $table->json('comment_list')->nullable()->comment('评论列表');
            $table->json('like_list')->nullable()->comment('点赞列表');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->index(['corp_id', 'job_id'], DB::getTablePrefix().'corp_job_index');
            $table->index(['corp_id', 'moment_id'], DB::getTablePrefix().'corp_moment_index');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."moments` comment '朋友圈表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moments');
    }
};
