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
        Schema::create('customers', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->char('user_id', 26)->nullable()->default('')->comment('成员ID');
            $table->string('external_user_id')->nullable()->default('')->comment('客户ID');
            $table->string('union_id')->nullable()->default('')->comment('客户 UNION_ID');
            $table->string('name')->nullable()->default('')->comment('客户名称');
            $table->string('avatar')->nullable()->default('')->comment('客户头像');
            $table->tinyInteger('type')->nullable()->default(0)->comment('客户类型，1=微信用户;2=企业微信用户');
            $table->tinyInteger('gender')->nullable()->default(0)->comment('客户性别 0=未知;1=男性;2=女性');
            $table->string('position')->nullable()->default('')->comment('客户职位');
            $table->string('corp_name')->nullable()->default('')->comment('客户所在企业的简称');
            $table->string('corp_full_name')->nullable()->default('')->comment('客户所在企业的主体名称');
            $table->json('external_profile')->nullable()->comment('客户的自定义展示信息');
            $table->string('remark')->nullable()->default('')->comment('对客户的备注');
            $table->string('description')->nullable()->default('')->comment('对客户的描述');
            $table->json('tag_ids')->nullable()->comment('对客户打企业标签的id列表');
            $table->string('remark_company')->nullable()->default('')->comment('对客户备注的所属公司名称');
            $table->json('remark_mobiles')->nullable()->comment('对客户备注的手机号');
            $table->integer('add_way')->nullable()->default(0)->comment('添加客户的来源');
            $table->json('wechat_channels')->nullable()->comment('当add_way为10时,应视频号信息');
            $table->string('operate_userid')->nullable()->default('')->comment('操作用户ID');
            $table->string('state')->nullable()->default('')->comment('企业自定义的state参数');
            $table->bigInteger('create_time')->nullable()->default(0)->comment('添加客户的时间');
            $table->string('delete_type')->nullable()->default('')->comment('删除类型[del_external_contact:删除企业客户, del_follow_user:删除跟进成员]');
            $table->json('extra')->nullable()->default(null)->comment('额外信息');
            $table->string('welcome_code')->nullable()->default('')->comment('欢迎语code');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'user_id', 'external_user_id'], DB::getTablePrefix().'corp_user_external_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."customers` comment '成员表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
