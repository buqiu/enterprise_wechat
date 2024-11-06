<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;

class RegisterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注册企微账号';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $code = $this->ask("请输入{$this->code}");

        if (Utils::empty($code)) {
            $this->error('标识不能为空');
            exit;
        }

        if (Corp::whereCode($code)->exists()) {
            $this->error("{$code}: 标识已存在");
            exit;
        }

        $corp = Corp::withTrashed()->whereCode($code)->first();
        if (! $corp) {
            $corp = new Corp;
        }
        $corp->fill($this->getCorpAsks(['code' => $code]));
        $corp->saveRestore();

        $this->view($corp);

        $this->components->info("账号({$corp->id})注册成功");
    }
}
