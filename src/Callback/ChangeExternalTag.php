<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback;

use Buqiu\EnterpriseWechat\Contracts\CallBackAbstract;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Services\CorpTagService;
use Exception;

class ChangeExternalTag extends CallBackAbstract
{
    /**
     * 企业客户标签创建
     *
     * @throws Exception
     */
    public function create(): void
    {
        [$tagId, $tagGroupId] = $this->parseData();

        EnterpriseWechatFacade::corpTag()->syncGet($tagId, $tagGroupId);
    }

    /**
     * 企业客户标签变更
     *
     * @throws Exception
     */
    public function update(): void
    {
        [$tagId, $tagGroupId] = $this->parseData();

        EnterpriseWechatFacade::corpTag()->syncGet($tagId, $tagGroupId);
    }

    /**
     * 企业客户标签删除
     *
     * @throws Exception
     */
    public function delete(): void
    {
        [$tagId, $tagGroupId] = $this->parseData();

        CorpTagService::delete($tagId, $tagGroupId);
    }

    /**
     * 企业客户标签重排
     *
     * @throws Exception
     */
    public function shuffle(): void
    {
        [$tagId, $tagGroupId] = $this->parseData();

        EnterpriseWechatFacade::corpTag()->syncGet($tagId, $tagGroupId);
    }

    /**
     * 解析数据
     */
    public function parseData(): array
    {
        [$tagData, $tagGroupData] = $this->data;

        $tagId = $tagData['id'] ?? [];

        $tagGroupId = $tagGroupData['id'] ?? [];

        if ($tagId) {
            $tagId = [$tagId];
        }

        if ($tagGroupId) {
            $tagGroupId = [$tagGroupId];
        }

        return [$tagId, $tagGroupId];
    }
}
