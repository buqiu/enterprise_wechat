<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Dto\StrategyDto;
use Buqiu\EnterpriseWechat\Services\StrategyService;
use Buqiu\EnterpriseWechat\Services\StrategyTagService;
use Exception;

class Strategy extends Lib
{
    /**
     * 同步规则组
     *
     * @throws Exception
     */
    public function syncList(): void
    {
        $cursor = null;
        do {
            [$cursor, $strategy] = $this->api->list($cursor);
            $strategy_ids        = array_unique(array_column($strategy, 'strategy_id'));
            foreach ($strategy_ids as $strategy_id) {
                $strategy_data              = $this->api->get($strategy_id);
                [$range_user, $range_party] = $this->getRange($strategy_id);
                StrategyService::syncEntity(new StrategyDto($strategy_data), $range_user, $range_party);
            }
        } while ($cursor);

        StrategyService::syncPath();
    }

    /**
     * 同步规则组范围
     *
     * @param  int  $strategy_id
     * @return array
     */
    public function getRange(int $strategy_id): array
    {
        $range_user_data  = [];
        $range_party_data = [];
        $cursor           = null;
        do {
            [$cursor, $ranges]          = $this->api->getRange($strategy_id, $cursor);
            [$range_user, $range_party] = StrategyService::parseRange($ranges);
            $range_user_data            = array_merge($range_user_data, $range_user);
            $range_party_data           = array_merge($range_party_data, $range_party);
        } while ($cursor);

        return [$range_user_data, $range_party_data];
    }

    /**
     * 新建规则组
     *
     * @throws Exception
     */
    public function create(array $data): void
    {
        $strategyDto = StrategyService::checkCreateParams($data);
        $strategy_id = $this->api->create($strategyDto->getData());

        [$range_user, $range_party] = StrategyService::parseRange($strategyDto->getRange());
        $strategyDto->setStrategyId($strategy_id);
        StrategyService::create($strategyDto, $range_user, $range_party);
    }

    /**
     * 修改规则组
     *
     * @throws Exception
     */
    public function update(array $data): void
    {
        $strategyDto = StrategyService::checkUpdateParams($data);

        $this->api->edit($strategyDto->getData());

        StrategyService::update($strategyDto);
    }

    /**
     * 删除规则组
     *
     * @throws Exception
     */
    public function delete(int $strategy_id): void
    {
        $this->api->delete($strategy_id);

        StrategyService::delete($strategy_id);
    }

    /**
     * 同步标签组列表
     *
     * @throws Exception
     */
    public function syncTagList(int $strategy_id): void
    {
        StrategyTagService::syncList($strategy_id, $this->api->getTag($strategy_id));
    }

    /**
     * 创建标签组
     *
     * @throws Exception
     */
    public function createTag(array $data): void
    {
        StrategyTagService::create($this->api->addTag($data));
    }

    /**
     * 编辑标签组
     *
     * @throws Exception
     */
    public function updateTag(array $data): void
    {
        [$corpTag, $corpTagDto, $data] = StrategyTagService::checkUpdateParams($data);

        $this->api->editTag($data);

        StrategyTagService::update($corpTag, $corpTagDto);
    }

    /**
     * 删除标签组
     *
     * @throws Exception
     */
    public function deleteTag(array $tag_id = [], array $group_id = []): void
    {
        $this->api->delTag($tag_id, $group_id);

        StrategyTagService::delete($tag_id, $group_id);
    }
}
