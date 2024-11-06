<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\StrategyTag\StrategyTagGroupDto;
use Buqiu\EnterpriseWechat\Dto\StrategyTagDto;
use Buqiu\EnterpriseWechat\Models\Strategy;
use Buqiu\EnterpriseWechat\Models\StrategyTag;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ParamsError;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StrategyTagService
{
    /**
     * 同步规则组
     *
     * @throws Exception
     */
    public static function syncList(int $strategy_id, array $tag_groups): void
    {
        $strategy = Strategy::withCorpId()->whereStrategyId($strategy_id)->firstOrFail();
        $tagIds   = [];
        foreach ($tag_groups as $tag_group) {
            $tagIds = array_merge($tagIds, StrategyTagService::syncGroup(new StrategyTagGroupDto($tag_group)));
        }
        $strategy->tag_ids = $tagIds;
        $strategy->save();
    }

    /**
     * 同步标签组
     *
     * @throws Exception
     */
    public static function syncGroup(StrategyTagGroupDto $strategyTagGroupDto): array
    {
        $tagIds = [];
        foreach ($strategyTagGroupDto->getTag() as $tagData) {
            $strategyTag = SyncService::strategyTag($strategyTagGroupDto, new StrategyTagDto($tagData));
            $tagIds[]    = $strategyTag->tag_id;
        }

        return $tagIds;
    }

    /**
     * 新建标签组
     *
     * @throws Exception
     */
    public static function create(array $data): void
    {
        $strategyTagGroupDto = new StrategyTagGroupDto($data);

        $strategy = Strategy::withCorpId()->whereStrategyId($strategyTagGroupDto->getStrategyId())->firstOrFail();

        if (Utils::empty($strategyTagGroupDto->getGroupId())) {
            $strategyTag = StrategyTag::withCorpId()->whereGroupId($strategyTagGroupDto->getGroupId())->first();
            $strategyTagGroupDto->setOrder(object_get($strategyTag, 'group_order'));
        } elseif (Utils::empty($strategyTagGroupDto->getGroupName())) {
            $strategyTag = StrategyTag::withCorpId()->whereGroupName($strategyTagGroupDto->getGroupName())->first();
            $strategyTagGroupDto->setOrder(object_get($strategyTag, 'group_order'));
        }

        $tagIds            = StrategyTagService::syncGroup($strategyTagGroupDto);
        $strategy->tag_ids = array_merge($strategy->tag_ids, $tagIds);
        $strategy->save();
    }

    /**
     * 检测入参(更新)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): array
    {
        $strategyTagDto = $originStrategyTagDto = new StrategyTagDto($data);

        if (Utils::empty($strategyTagDto->getId())) {
            throw new Exception('id: '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }

        $strategyTag = StrategyTag::withCorpId()->whereTagId($strategyTagDto->getId())->first();
        if (! $strategyTag) {
            $strategyTag    = StrategyTag::withCorpId()->whereGroupId($strategyTagDto->getId())->first();
            $strategyTagDto = $strategyTagDto->convertGroup();
        }

        if (! $strategyTag) {
            throw (new ModelNotFoundException)->setModel(
                StrategyTag::class, array_filter([$data['id']])
            );
        }

        return [$strategyTag, $strategyTagDto, $originStrategyTagDto->getData()];
    }

    /**
     * 更新规则组标签
     */
    public static function update(StrategyTag $strategyTag, StrategyTagDto|StrategyTagGroupDto $strategyTagDto): void
    {
        if ($strategyTagDto instanceof StrategyTagDto) {
            $strategyTagDto->fill($strategyTag);
            $strategyTag->save();
        }

        if ($strategyTagDto instanceof StrategyTagGroupDto) {
            StrategyTag::withCorpId()->whereGroupId($strategyTagDto->getGroupId())->update($strategyTagDto->getModelData());
        }
    }

    /**
     * 删除规则组标签
     */
    public static function delete(array $tag_id = [], array $group_id = []): void
    {
        SyncService::deleteStrategyTag($tag_id, $group_id);
    }
}
