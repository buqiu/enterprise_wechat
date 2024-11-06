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
        Schema::create('strategies', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->bigInteger('strategy_id')->nullable()->default(0)->comment('规则组ID');
            $table->bigInteger('parent_id')->nullable()->default(0)->comment('父规则组ID');
            $table->json('path')->nullable()->comment('上级-末级路径');
            $table->string('strategy_name')->nullable()->default('')->comment('规则组名称');
            $table->bigInteger('create_time')->nullable()->default(0)->comment('规则组创建时间戳');
            $table->json('admin_list')->nullable()->comment('规则组管理员列表');
            $table->json('privilege')->nullable()->comment('权限');
            $table->json('range_user')->nullable()->comment('管理范围内配置的成员列表');
            $table->json('range_party')->nullable()->comment('管理范围内配置的部门对客户打企业标签的ID列表');
            $table->json('tag_ids')->nullable()->comment('对规则打企业标签的ID列表');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'strategy_id'], DB::getTablePrefix().'corp_strategy_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."strategies` comment '规则组表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategies');
    }
};
