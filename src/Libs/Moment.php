<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\MomentService;
use Exception;

class Moment extends Lib
{
    /**
     * 创建发表任务
     *
     * @throws Exception
     */
    public function send(array $data): void
    {
        $momentDto = MomentService::checkCreateParams($data);

        $momentDto->setJobId($this->api->send($momentDto->getParams()));

        MomentService::send($momentDto);
    }

    /**
     * 获取任务结果
     *
     * @throws Exception
     */
    public function getResult(string $job_id): array
    {
        [$status, $result] = $this->api->getResult($job_id);

        MomentService::syncResult($job_id, $status, $result);

        return compact('status', 'result');
    }

    /**
     * 取消发表
     *
     * @throws Exception
     */
    public function cancelSend(string $moment_id): void
    {
        $this->api->cancelSend($moment_id);

        MomentService::cancelSend($moment_id);
    }
}
