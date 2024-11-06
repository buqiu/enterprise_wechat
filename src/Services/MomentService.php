<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Moment\MomentResultDto;
use Buqiu\EnterpriseWechat\Dto\MomentDto;
use Buqiu\EnterpriseWechat\Models\Moment;
use Exception;

class MomentService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): MomentDto
    {
        return new MomentDto($data);
    }

    /**
     * 发送消息
     *
     * @throws Exception
     */
    public static function send(MomentDto $momentDto): Moment
    {
        return SyncService::moment($momentDto);
    }

    /**
     * 获取任务结果
     *
     * @throws Exception
     */
    public static function syncResult(string $job_id, int $status, array $data): void
    {
        $momentResult = new MomentResultDto($data);
        $momentResult->setStatus($status);

        SyncService::momentResult($job_id, $momentResult);
    }

    /**
     * 取消发表
     *
     * @throws Exception
     */
    public static function cancelSend(string $moment_id): void
    {
        SyncService::cancelMoment($moment_id);
    }
}
