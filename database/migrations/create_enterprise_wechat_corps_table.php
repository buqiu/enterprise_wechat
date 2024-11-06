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
        Schema::create('corps', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('corp_id')->nullable()->default('')->comment('企业ID');
            $table->string('corp_secret')->nullable()->default('')->comment('访问密钥');
            $table->string('token')->nullable()->default('');
            $table->string('encoding_aes_key')->nullable()->default('');
            $table->string('agent_id')->nullable()->default('');
            $table->string('code')->comment('标识')->unique();
            $table->string('describe')->nullable()->default('')->comment('描述');
            $table->tinyInteger('is_deleted')->default(0)->index()->comment('删除标识: 1=是;0=否');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
        DB::statement('ALTER TABLE `'.DB::getTablePrefix()."corps` comment '企微账号表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corps');
    }
};
