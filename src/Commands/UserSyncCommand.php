<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Services\UserService;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;

class UserSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:user:sync {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步成员';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $corp = Corp::whereCode($this->argument('code'))->firstOrFail();
        EnterpriseWechatFacade::connect(code: $corp->code);

        $this->info($this->description.'开始...');

        $departments = Department::withCorpId()->get();

        $bar = $this->output->createProgressBar($departments->count());

        $bar->start();

        foreach ($departments as $department) {
            $info = [
                'name'          => $department->name,
                'department_id' => $department->department_id,
            ];

            try {
                UserService::syncList(EnterpriseWechatFacade::user()->api()->list($department->department_id), true);
            } catch (Exception $exception) {
                LogHelper::error('user_sync_fail', array_merge([
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'code'    => $exception->getCode(),
                ], $info));
                $this->error(json_encode($info, JSON_UNESCAPED_UNICODE));
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info(PHP_EOL.$this->description.'完成.');
    }
}
