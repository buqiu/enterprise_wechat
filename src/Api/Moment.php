<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Moment extends Api
{
    /**
     * 创建发表任务
     *
     * @link https://developer.work.weixin.qq.com/document/path/95094
     *
     * @throws GuzzleException
     */
    public function send(array $data): string
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/add_moment_task', $data, $this->mergeTokenData());

        return $result['jobid'];
    }

    /**
     * 获取任务创建结果
     *
     * @link https://developer.work.weixin.qq.com/document/path/95094
     *
     * @throws GuzzleException
     */
    public function getResult(string $jobid): array
    {
        $result = $this->httpGet('/cgi-bin/externalcontact/get_moment_task_result', $this->mergeTokenData(compact('jobid')));

        return [$result['status'], $result['result']];
    }

    /**
     * 停止发表企业朋友圈
     *
     * @link https://developer.work.weixin.qq.com/document/path/97612
     *
     * @throws GuzzleException
     */
    public function cancelSend(string $moment_id): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/cancel_moment_task', compact('moment_id'), $this->mergeTokenData());
    }
}
