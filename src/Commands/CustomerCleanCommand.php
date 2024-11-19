<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Dto\Customer\ExternalContactDto;
use Buqiu\EnterpriseWechat\Dto\Customer\FollowUserDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;

class CustomerCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:customer:clean {code} {--chunk=10000} {--sleep=10} {--clean-version=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步客户-数据清洗';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $corp = Corp::whereCode($this->argument('code'))->firstOrFail();

        EnterpriseWechatFacade::connect(code: $corp->code);

        $this->components->info($this->description.'开始...');

        $customerCount = Customer::withCorpId()->withTrashed()->count();

        $bar = $this->output->createProgressBar($customerCount);

        $bar->start();

        $number = 0;

        $customer = null;

        do {
            $customerQuery = Customer::withCorpId()->withTrashed();
            if ($customer) {
                $customerQuery->where('id', '>', $customer->id);
            }
            $customer = $customerQuery->orderBy('id')->limit(1)->first();

            if ($customer) {

                $this->__cleanCustomer($customer);

                $this->__sleepExec(++$number, $customer);

                $bar->advance();
            }

        } while ($customer);

        $bar->finish();

        $this->line('');
        $this->components->info(PHP_EOL.$this->description.'完成.');
    }

    public function __sleepExec(int $number, Customer $customer): void
    {
        $chunk = (int) $this->option('chunk');
        $sleep = (int) $this->option('sleep');
        if ($number % $chunk !== 0) {
            return;
        }

        $this->line('');
        $this->components->info("已执行 $number 条, 最新客户ID: {$customer->id}, 休息片刻...");

        for ($i = $sleep; $i >= 1; $i--) {
            $this->info("倒计时 $i 秒");
            sleep(1);
        }

        $this->line('');
    }

    public function __cleanCustomer(Customer $customer): void
    {
        $extra = $customer->extra;
        if (isset($extra['clean_version']) && $extra['clean_version'] == $this->option('clean-version')) {
            return;
        }

        try {
            $cursor = null;
            do {
                [$cursor, $external_contact, $follow_users] = EnterpriseWechatFacade::customer()->api()->get($customer->external_user_id, $cursor);

                $hit = $this->__parseApi($customer, $external_contact, $follow_users);

                if (! $hit) {
                    $this->delCustomer($customer);
                }

            } while ($cursor);
        } catch (Exception $exception) {
            if ($exception->getCode()) {
                $this->delCustomer($customer);
            } else {
                LogHelper::error('sync_customer_clean_fail', [
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'code'    => $exception->getCode(),
                ]);
                $this->error(json_encode($customer->toArray(), JSON_UNESCAPED_UNICODE));
            }
        }
    }

    public function delCustomer(Customer $customer): void
    {
        $customer->delete_type = 'del_external_contact';

        $customer->extra = array_merge($customer->extra, [
            'clean_version' => $this->option('clean-version'),
            'clean_msg'     => 'command_exec',
        ]);

        $customer->delete();
    }

    /**
     * @throws Exception
     */
    public function __parseApi(Customer $customer, $external_contact, $follow_users): bool
    {
        $hit = false;
        foreach ($follow_users as $follow_user) {
            $hitResult = $this->__cleanApi($customer, new ExternalContactDto($external_contact), new FollowUserDto($follow_user));
            if ($hitResult) {
                $hit = true;
            }
        }

        return $hit;
    }

    /**
     * @throws Exception
     */
    public function __cleanApi(Customer $customer, ExternalContactDto $externalContactDto, FollowUserDto $followUserDto): bool
    {
        $user = User::withCorpId()->whereAccountId($followUserDto->getUserId())->first();
        if (! $user) {
            return false;
        }

        if ($customer->user_id === $user->getKey()) {
            $this->__modifyCustomer($customer, $externalContactDto, $followUserDto);

            return true;
        }

        $customerQuery = Customer::withCorpId()->whereUserId($user->getKey())->whereExternalUserId($customer->external_user_id)->withTrashed()->first();
        if ($customerQuery) {
            $this->__modifyCustomer($customerQuery, $externalContactDto, $followUserDto);
        }

        return false;
    }

    public function __modifyCustomer(Customer $customer, ExternalContactDto $externalContactDto, FollowUserDto $followUserDto): Customer
    {
        $customer->reset();
        $externalContactDto->fill($customer);
        $followUserDto->fill($customer);
        $customer->extra = array_merge($customer->extra, ['clean_version' => $this->option('clean-version')]);
        $customer->saveRestore();

        return $customer;
    }
}
