<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagGroupDto;
use Buqiu\EnterpriseWechat\Dto\CorpTagDto;
use Buqiu\EnterpriseWechat\Events\CustomerTagModelEvent;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Models\CorpTag as CorpTagModel;
use Buqiu\EnterpriseWechat\Services\SyncService;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;

class CustomerTagSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:customer-tag:sync {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步客户标签';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $corp = Corp::whereCode($this->argument('code'))->firstOrFail();
        EnterpriseWechatFacade::connect(code: $corp->code);

        $tag_groups = EnterpriseWechatFacade::corpTag()->api()->list();

        $this->syncData($tag_groups, 'customer_tag_sync_fail');

        $this->info('=============================================');

        $this->syncList();
    }

    /**
     * @throws Exception
     */
    public function syncList(): void
    {
        $corpTagGroupIds = CorpTagModel::withCorpId()->pluck('group_id')->unique();
        foreach ($corpTagGroupIds as $corpTagGroupId) {
            $tag_groups = EnterpriseWechatFacade::corpTag()->api()->list([], [$corpTagGroupId]);
            $this->syncData($tag_groups, 'customer_tag_sync_delete_tag_fail');
        }
    }

    /**
     * @throws Exception
     */
    public function syncData(array $tag_groups, $err_msg = ''): void
    {
        foreach ($tag_groups as $tag_group) {
            $corpTagGroupDto = new CorpTagGroupDto($tag_group);
            foreach ($corpTagGroupDto->getTag() as $tagData) {
                $info = [
                    'group_id'   => $tag_group['group_id'],
                    'group_name' => $tag_group['group_name'],
                    'tag_id'     => $tagData['id'],
                    'user_name'  => $tagData['name'],
                ];
                try {
                    $corpTag = SyncService::corpTag($corpTagGroupDto, new CorpTagDto($tagData));
                    if ($corpTag) {
                        CustomerTagModelEvent::dispatch($corpTag->getKey());
                    }
                    $this->info(json_encode($info, JSON_UNESCAPED_UNICODE));
                } catch (Exception $exception) {
                    LogHelper::error($err_msg, array_merge($info, [
                        'message' => $exception->getMessage(),
                        'file'    => $exception->getFile(),
                        'line'    => $exception->getLine(),
                        'code'    => $exception->getCode(),
                    ]));
                    $this->error(json_encode($info, JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }
}
