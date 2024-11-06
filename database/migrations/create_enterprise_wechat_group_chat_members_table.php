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
        Schema::create('group_chat_members', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('chat_id')->nullable()->default('')->comment('客户群ID');
            $table->tinyInteger('type')->nullable()->default(0)->comment('成员类型[1企业成员2外部联系人]');
            $table->string('user_id')->nullable()->default('')->comment('群成员[企业成员ID|外部联系人ID]');
            $table->string('union_id')->nullable()->default('')->comment('外部联系人（微信unionid）');
            $table->bigInteger('join_time')->nullable()->default(0)->comment('入群时间');
            $table->tinyInteger('join_scene')->nullable()->default(0)->comment('入群方式[1由群成员直接邀请入群2由群成员邀请链接入群3通过扫描群二维码入群]');
            $table->string('group_nick_name')->nullable()->default('')->comment('在群里的昵称');
            $table->string('name')->nullable()->default('')->comment('群成员的名字');
            $table->string('invitor_user_id')->nullable()->default('')->comment('邀请者userid');
            $table->tinyInteger('is_admin')->default(0)->comment('是否群管理员[1是0否]');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'chat_id', 'type', 'user_id'], DB::getTablePrefix().'corp_chat_user_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."group_chat_members` comment '客户群成员表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chat_members');
    }
};
