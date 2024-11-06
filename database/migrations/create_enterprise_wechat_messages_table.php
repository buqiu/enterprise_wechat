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
        Schema::create('messages', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->tinyInteger('msg_type')->nullable()->default(0)->comment('消息类型 1 应用消息 2 群机器人 3 企业群发 4 欢迎语code');
            $table->json('content')->nullable()->comment('消息内容');
            $table->string('msg_id')->nullable()->default('')->comment('应用消息id');
            $table->string('msg_key')->nullable()->default('')->comment('群机器人key');
            $table->string('welcome_code')->nullable()->default('')->comment('欢迎语code');
            $table->tinyInteger('recall_status')->default(0)->comment('是否被撤回[1是0否]');
            $table->index(['corp_id', 'msg_type', 'msg_id'], DB::getTablePrefix().'corp_message_type_id_index');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."messages` comment '应用消息表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
