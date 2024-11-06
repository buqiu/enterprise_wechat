<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagGroupDto;
use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagMarkDto;
use Buqiu\EnterpriseWechat\Dto\CorpTagDto;
use Buqiu\EnterpriseWechat\Events\CustomerTagModelEvent;
use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ParamsError;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CorpTagService
{
    /**
     * 同步标签列表
     *
     * @throws Exception
     */
    public static function syncList(array $tag_groups, bool $trigger_event = false): void
    {
        foreach ($tag_groups as $tag_group) {
            CorpTagService::syncGroup(new CorpTagGroupDto($tag_group), $trigger_event);
        }
    }

    /**
     * 同步标签组
     *
     * @throws Exception
     */
    public static function syncGroup(CorpTagGroupDto $corpTagGroupDto, bool $trigger_event = false): void
    {
        foreach ($corpTagGroupDto->getTag() as $tagData) {
            $corpTag = SyncService::corpTag($corpTagGroupDto, new CorpTagDto($tagData));
            if ($corpTag && $trigger_event) {
                CustomerTagModelEvent::dispatch($corpTag->getKey());
            }
        }
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): CorpTagGroupDto
    {
        return new CorpTagGroupDto($data);
    }

    /**
     * 检测入参(更新)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): array
    {
        $corpTagDto = $originCorpTagDto = new CorpTagDto($data);

        if (Utils::empty($corpTagDto->getId())) {
            throw new Exception('id: '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }

        $corpTag = CorpTag::withCorpId()->whereTagId($corpTagDto->getId())->first();
        if (! $corpTag) {
            $corpTag    = CorpTag::withCorpId()->whereGroupId($corpTagDto->getId())->first();
            $corpTagDto = $corpTagDto->convertGroup();
        }

        if (! $corpTag) {
            throw (new ModelNotFoundException)->setModel(
                CorpTag::class, array_filter([$data['id']])
            );
        }

        return [$corpTag, $corpTagDto, $originCorpTagDto->getData()];
    }

    /**
     * 新建企业标签
     *
     * @throws Exception
     */
    public static function create(array $data): void
    {
        $corpTagGroupDto = new CorpTagGroupDto($data);

        if (Utils::empty($corpTagGroupDto->getGroupId())) {
            $corpTag = CorpTag::withCorpId()->whereGroupId($corpTagGroupDto->getGroupId())->first();
            $corpTagGroupDto->setOrder(object_get($corpTag, 'group_order'));
        } elseif (Utils::empty($corpTagGroupDto->getGroupName())) {
            $corpTag = CorpTag::withCorpId()->whereGroupName($corpTagGroupDto->getGroupName())->first();
            $corpTagGroupDto->setOrder(object_get($corpTag, 'group_order'));
        }

        CorpTagService::syncGroup($corpTagGroupDto);
    }

    /**
     * 更新企业标签
     */
    public static function update(CorpTag $corpTag, CorpTagDto|CorpTagGroupDto $corpTagDto): void
    {
        if ($corpTagDto instanceof CorpTagDto) {
            $corpTagDto->fill($corpTag);
            $corpTag->save();
        }

        if ($corpTagDto instanceof CorpTagGroupDto) {
            CorpTag::withCorpId()->whereGroupId($corpTagDto->getGroupId())->update($corpTagDto->getModelData());
        }
    }

    /**
     * 删除企业标签
     */
    public static function delete(array $tag_id = [], array $group_id = []): void
    {
        SyncService::deleteCorpTag($tag_id, $group_id);
    }

    /**
     * 解析 Tag 数据
     */
    public static function parseTagIdData(array $tag_groups): array
    {
        $data = [];
        foreach ($tag_groups as $tag_group) {
            if ($tag_group['deleted']) {
                continue;
            }
            foreach ($tag_group['tag'] as $tag) {
                if ($tag['deleted']) {
                    continue;
                }
                $data[] = $tag['id'];
            }
        }

        return $data;
    }

    /**
     * 编辑客户标签入参(更新)
     *
     * @throws Exception
     */
    public static function checkMarkParams(array $data): CorpTagMarkDto
    {
        return new CorpTagMarkDto($data);
    }

    /**
     * 编辑客户标签
     *
     * @throws Exception
     */
    public static function mark(CorpTagMarkDto $corpTagMarkDto): void
    {
        SyncService::remarkCustomerTag($corpTagMarkDto);
    }
}
