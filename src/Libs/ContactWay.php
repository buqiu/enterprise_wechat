<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\ContactWayService;
use Exception;

class ContactWay extends Lib
{
    /**
     * 配置企业已配置的「联系我」方式
     * @note create
     * @param  array  $data
     * @return \Buqiu\EnterpriseWechat\Models\ContactWay
     * @throws Exception
     * @author eva
     *
     * */
    public function create(array $data): \Buqiu\EnterpriseWechat\Models\ContactWay
    {
        $dto    = ContactWayService::checkCreateParams($data);
        $result = $this->api->create($dto->getData());

        return ContactWayService::create($dto, $result);
    }

    /**
     * 更新企业已配置的「联系我」方式
     * @note update
     * @param  string  $config_id
     * @param  array  $data
     * @return \Buqiu\EnterpriseWechat\Models\ContactWay|null
     * @throws Exception
     * @author eva
     *
     * */
    public function update(string $config_id, array $data): ?\Buqiu\EnterpriseWechat\Models\ContactWay
    {
        $dto = ContactWayService::checkUpdateParams(array_merge($data, compact('config_id')));
        $this->api->update($dto->getData());

        return ContactWayService::update($dto);
    }

    public function delete(string $config_id): void
    {
        $this->api->delete($config_id);

        ContactWayService::delete($config_id);
    }
}
