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
        Schema::create('transfer_group_chats', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('chat_id')->nullable()->comment('客户群ID');
            $table->string('new_user_id')->nullable()->default('')->comment('新群主ID');
            $table->integer('transfer_err_code')->nullable()->default(0)->comment('错误码; 0表示成功');
            $table->string('transfer_err_msg')->nullable()->default('')->comment('错误描述');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."transfer_group_chats` comment '转接客户群表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_group_chats');
    }
};
