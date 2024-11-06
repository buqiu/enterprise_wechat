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
        Schema::create('transfer_customers', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('handover_user_id')->nullable()->default('')->comment('原跟进成员ID');
            $table->string('takeover_user_id')->nullable()->default('')->comment('接替成员ID');
            $table->string('external_user_id')->nullable()->default('')->comment('客户ID');
            $table->string('transfer_success_msg')->nullable()->default('')->comment('转移成功后发给客户的消息');
            $table->integer('transfer_err_code')->nullable()->default(0)->comment('对此客户进行分配的结果; 0表示成功发起接替');
            $table->tinyInteger('transfer_status')->nullable()->default(0)->comment('接替状态; 0-发起接替 1-接替完毕 2-等待接替 3-客户拒绝 4-接替成员客户达到上限');
            $table->bigInteger('takeover_time')->nullable()->default(0)->comment('接替客户的时间');
            $table->index(['corp_id', 'handover_user_id', 'takeover_user_id'], DB::getTablePrefix().'corp_handover_takeover_index');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."transfer_customers` comment '转接客户表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_customers');
    }
};
