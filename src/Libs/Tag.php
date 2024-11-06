<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Models\Tag as TagModel;
use Buqiu\EnterpriseWechat\Services\TagService;
use Buqiu\EnterpriseWechat\Services\UserTagService;
use Exception;

/**
 * 通讯录管理-标签管理
 */
class Tag extends Lib
{
    /**
     * 同步标签列表
     *
     * @throws Exception
     */
    public function syncList(bool $force = false): void
    {
        if ($force) {
            TagModel::withCorpId()->delete();
        }
        TagService::syncList($this->api->list(), true);
    }

    /**
     * 新建标签
     *
     * @throws Exception
     */
    public function create(array $data): void
    {
        $tagDto = TagService::checkCreateParams($data);

        TagService::create($tagDto, $this->api->create($tagDto->getData()));
    }

    /**
     * 修改标签
     *
     * @throws Exception
     */
    public function update(int $tag_id, string $tag_name): void
    {
        $tagDto = TagService::checkUpdateParams(['tagid' => $tag_id, 'tagname' => $tag_name]);
        $this->api->update($tagDto->getData());
        TagService::update($tagDto);
    }

    /**
     * 删除标签
     *
     * @throws Exception
     */
    public function delete(int $tag_id): void
    {
        $this->api->delete($tag_id);

        TagService::delete($tag_id);
    }

    /**
     * 同步标签成员
     */
    public function syncUserTagList(int $tag_id): void
    {
        [$user_lists] = $this->api->get($tag_id);

        UserTagService::syncList($tag_id, array_column($user_lists, 'userid'));
    }

    /**
     * 添加标签成员
     */
    public function addTagUsers(int $tag_id, array $user_list = [], array $party_list = []): void
    {
        $this->api->addTagUsers($tag_id, $user_list, $party_list);

        UserTagService::addList($tag_id, $user_list, $party_list);
    }

    /**
     * 删除标签成员
     */
    public function delTagUsers(int $tag_id, array $user_list = [], array $party_list = []): void
    {
        $this->api->delTagUsers($tag_id, $user_list, $party_list);

        UserTagService::delList($tag_id, $user_list, $party_list);
    }
}
