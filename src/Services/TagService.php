<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Tag\CreateDto;
use Buqiu\EnterpriseWechat\Dto\Tag\UpdateDto;
use Buqiu\EnterpriseWechat\Dto\TagDto;
use Buqiu\EnterpriseWechat\Events\TagModelEvent;
use Buqiu\EnterpriseWechat\Models\Tag;
use Buqiu\EnterpriseWechat\Models\User;
use Exception;

class TagService
{
    /**
     * 同步标签列表
     *
     * @throws Exception
     */
    public static function syncList(array $tag_lists, bool $trigger_event = false): void
    {
        foreach ($tag_lists as $tag_list) {
            $tag = SyncService::tag(new TagDto($tag_list));
            if ($trigger_event) {
                TagModelEvent::dispatch($tag->getKey());
            }
        }
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): TagDto
    {
        return new CreateDto($data);
    }

    /**
     * 检测入参(更新)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): TagDto
    {
        return new UpdateDto($data);
    }

    /**
     * 新建标签
     */
    public static function create(TagDto $tagDto, int $tag_id): void
    {
        $tagDto->setTagId($tag_id);
        SyncService::tag($tagDto);
    }

    /**
     * 修改标签
     */
    public static function update(TagDto $tagDto): void
    {
        SyncService::tag($tagDto);
    }

    /**
     * 删除标签
     */
    public static function delete(int $tag_id): void
    {
        SyncService::deleteTag($tag_id);

        $users = User::withCorpId()->whereJsonContains('tag_ids', $tag_id)->get();
        foreach ($users as $user) {
            SyncService::deleteUserTagId($user, $tag_id);
        }
    }
}
