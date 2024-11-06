<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Strategy\CreateDto;
use Buqiu\EnterpriseWechat\Dto\Strategy\UpdateDto;
use Buqiu\EnterpriseWechat\Dto\StrategyDto;
use Buqiu\EnterpriseWechat\Models\Strategy;
use Exception;

class StrategyService
{
    /**
     * 同步规则组
     *
     * @throws Exception
     */
    public static function syncEntity(StrategyDto $strategyDto, array $range_user, array $range_party): Strategy
    {
        $strategyDto->setRangeUser($range_user);
        $strategyDto->setRangeParty($range_party);

        return SyncService::strategy($strategyDto);
    }

    /**
     * 同步 PATH
     *
     * @return void
     */
    public static function syncPath(): void
    {
        $strategies = Strategy::withCorpId()->whereParentId(0)->get();
        foreach ($strategies as $strategy) {
            SyncService::strategyCallPath($strategy);
        }
    }

    /**
     * 新建规则组
     *
     * @param  CreateDto  $strategyDto
     * @param  array  $range_user
     * @param  array  $range_party
     * @return void
     */
    public static function create(CreateDto $strategyDto, array $range_user, array $range_party): void
    {
        $strategyDto->setRangeUser($range_user);
        $strategyDto->setRangeParty($range_party);

        $strategy = SyncService::strategy($strategyDto);
        SyncService::strategyCallPath($strategy);
    }

    /**
     * 更新规则组
     */
    public static function update(UpdateDto $strategyDto): void
    {
        SyncService::modifyStrategy($strategyDto);
    }

    /**
     * 删除规则组
     */
    public static function delete(int $strategy_id): void
    {
        SyncService::deleteStrategy($strategy_id);
    }

    /**
     * 解析规则组范围
     *
     * @param  array  $rangeData
     * @return array[]
     */
    public static function parseRange(array $rangeData): array
    {
        $range_user  = [];
        $range_party = [];
        foreach ($rangeData as $range) {
            if ($range['type'] === 1) {
                $range_user[] = $range['userid'];
            } elseif ($range['type'] === 2) {
                $range_party[] = $range['partyid'];
            }
        }

        return [$range_user, $range_party];
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): CreateDto
    {
        return new CreateDto($data);
    }

    /**
     * 检测入参(编辑)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): UpdateDto
    {
        return new UpdateDto($data);
    }
}
