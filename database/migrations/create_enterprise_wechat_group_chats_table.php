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
        Schema::create('group_chats', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('chat_id')->nullable()->default('')->comment('客户群ID');
            $table->tinyInteger('status')->nullable()->default(0)->comment('客户群跟进状态[0跟进人正常1跟进人离职2离职继承中3离职继承完成');
            $table->string('name')->nullable()->default('')->comment('群名');
            $table->char('owner_id', 26)->nullable()->default('')->comment('群主userid');
            $table->bigInteger('create_time')->nullable()->default(0)->comment('群的创建时间');
            $table->text('notice')->nullable()->comment('群公告');
            $table->string('member_version')->nullable()->default('')->comment('当前群成员版本号');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'chat_id'], DB::getTablePrefix().'corp_chat_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."group_chats` comment '客户群表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chats');
    }
};
