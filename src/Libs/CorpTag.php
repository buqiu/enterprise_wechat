<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Models\CorpTag as CorpTagModel;
use Buqiu\EnterpriseWechat\Services\CorpTagService;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;

class CorpTag extends Lib
{
    /**
     * 同步企业标签
     *
     * @throws Exception
     */
    public function syncList(): void
    {
        CorpTagService::syncList($this->api->list());
        $corpTagGroupIds = CorpTagModel::withCorpId()->pluck('group_id')->unique();
        foreach ($corpTagGroupIds as $corpTagGroupId) {
            CorpTagService::syncList($this->api->list([], [$corpTagGroupId]), true);
        }
    }

    /**
     * 基于 ID 同步企业标签
     *
     * @throws Exception
     */
    public function syncGet(array $tag_id = [], array $group_id = []): void
    {
        CorpTagService::syncList($this->api->list($tag_id, $group_id));
    }

    /**
     * 新建企业标签
     *
     * @throws Exception
     */
    public function create(array $data): void
    {
        $corpTagGroupDto = CorpTagService::checkCreateParams($data);

        $result = $this->api->create($corpTagGroupDto->getData());

        CorpTagService::create($result);
    }

    /**
     * 更新企业标签
     *
     * @throws Exception
     */
    public function update(array $data): void
    {
        [$corpTag, $corpTagDto, $data] = CorpTagService::checkUpdateParams($data);

        $this->api->update($data);

        CorpTagService::update($corpTag, $corpTagDto);
    }

    /**
     * 删除企业标签
     *
     * @throws Exception
     */
    public function delete(array $tag_id = [], array $group_id = []): void
    {
        $this->api->delete($tag_id, $group_id);

        CorpTagService::delete($tag_id, $group_id);
    }

    /**
     * 编辑客户企业标签
     *
     * @throws Exception
     */
    public function mark(array $data): void
    {
        $corpTagMarkDto  = CorpTagService::checkMarkParams($data);
        $corpTagMarkData = $corpTagMarkDto->getData();

        if (Utils::notEmpty($corpTagMarkDto->getAddTag())) {
            $corpTagMarkDto->setAddTag(CorpTagService::parseTagIdData($this->api->list($corpTagMarkDto->getAddTag())));
        }

        if (Utils::notEmpty($corpTagMarkDto->getRemoveTag())) {
            $corpTagMarkDto->setRemoveTag(CorpTagService::parseTagIdData($this->api->list($corpTagMarkDto->getRemoveTag())));
        }
        $this->api->mark($corpTagMarkData);

        CorpTagService::mark($corpTagMarkDto);
    }
}
