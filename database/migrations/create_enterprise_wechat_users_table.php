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
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('account_id')->nullable()->default('')->comment('账号');
            $table->string('name')->nullable()->default('')->comment('名称');
            $table->string('mobile')->nullable()->default('')->comment('手机号码');
            $table->char('department_id', 26)->nullable()->default('')->comment('部门ID')->index();
            $table->integer('order')->nullable()->default(0)->comment('部门内的排序值');
            $table->string('position')->nullable()->default('')->comment('职务');
            $table->tinyInteger('gender')->nullable()->default(0)->comment('性别: 0=未定义，1=男性，2=女性');
            $table->string('email')->nullable()->default('')->comment('邮件');
            $table->string('biz_mail')->nullable()->default('')->comment('企业邮箱');
            $table->json('is_leader_in_dept')->nullable()->comment('所在的部门内是否为部门负责人: 0-否；1-是');
            $table->json('direct_leader')->nullable()->comment('直属上级UserID');
            $table->string('avatar')->nullable()->default('')->comment('头像url');
            $table->string('thumb_avatar')->nullable()->default('')->comment('头像缩略图url');
            $table->string('telephone')->nullable()->default('')->comment('座机');
            $table->string('alias')->nullable()->default('')->comment('别名');
            $table->json('ext_attr')->nullable()->comment('扩展属性');
            $table->tinyInteger('status')->nullable()->default(0)->comment('激活状态: 1=已激活，2=已禁用，4=未激活，5=退出企业 6=离职');
            $table->string('qr_code')->nullable()->default('')->comment('员工个人二维码');
            $table->json('external_profile')->nullable()->comment('成员对外属性');
            $table->string('external_position')->nullable()->default('')->comment('对外职务');
            $table->string('address')->nullable()->default('')->comment('地址');
            $table->string('open_userid')->nullable()->default('')->comment('全局唯一');
            $table->json('tag_ids')->nullable()->comment('对成员打的标签id列表');
            $table->bigInteger('main_department')->nullable()->default(0)->comment('主部门');
            $table->tinyInteger('customer_enabled')->nullable()->default(0)->comment('是否启用客户联系功能');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->unique(['corp_id', 'account_id'], DB::getTablePrefix().'corp_user_unique');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."users` comment '成员表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
