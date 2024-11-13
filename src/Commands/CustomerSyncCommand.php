<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Events\CustomerModelEvent;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Services\CustomerService;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;

class CustomerSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:customer:sync {code} {first_user_id} {end_user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步客户';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $corp = Corp::whereCode($this->argument('code'))->firstOrFail();
        EnterpriseWechatFacade::connect(code: $corp->code);

        $users = User::whereCorpId($corp->corp_id)->where('id', '>=', $this->argument('first_user_id'))->where('id', '<=', $this->argument('end_user_id'))->get();

        $bar = $this->output->createProgressBar($users->count());

        $bar->start();

        foreach ($users as $user) {
            $this->line('');

            try {
                $this->performTask($user);
            } catch (Exception $exception) {
                LogHelper::error('user_sync_customer_fail', array_merge($user->toArray(), [
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'code'    => $exception->getCode(),
                ]));
                $this->error(json_encode($user->toArray(), JSON_UNESCAPED_UNICODE));
            }
            $bar->advance();
        }

        $bar->finish();
    }

    public function performTask(User $user): void
    {
        $cursor = null;
        do {
            [$cursor, $contact_list] = EnterpriseWechatFacade::customer()->api()->batchGetByUser([$user->account_id], $cursor);

            foreach ($contact_list as $contact) {

                $info = [
                    'account_id' => $contact['follow_info']['userid'],
                    'user_id'    => $contact['external_contact']['external_userid'],
                    'user_name'  => $contact['external_contact']['name'] ?? '',
                ];

                try {
                    $customer = CustomerService::sync($contact['external_contact'], $contact['follow_info']);
                    CustomerModelEvent::dispatch($customer->getKey());
                    $this->info(json_encode($info, JSON_UNESCAPED_UNICODE));
                } catch (Exception $exception) {
                    LogHelper::error('customer_sync_fail', array_merge($contact, [
                        'message' => $exception->getMessage(),
                        'file'    => $exception->getFile(),
                        'line'    => $exception->getLine(),
                        'code'    => $exception->getCode(),
                    ]));
                    $this->error(json_encode($info, JSON_UNESCAPED_UNICODE));
                }
            }

        } while ($cursor);

        $this->info("{$user->account_id} 同步完成");
    }
}
