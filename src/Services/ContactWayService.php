<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\ContactWay\CreateDto;
use Buqiu\EnterpriseWechat\Dto\ContactWay\UpdateDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\ContactWay;
use Exception;

class ContactWayService
{
    /**
     * 配置客户联系「联系我」方式
     * @note create
     * @param  CreateDto  $dto
     * @param  array  $data
     * @return ContactWay
     *
     * @author eva
     *
     * */
    public static function create(CreateDto $dto, array $data): ContactWay
    {
        $dto->config_id = $data['config_id'];
        $dto->qr_code   = $data['qr_code'];

        $model = ContactWay::withCorpId()->whereConfigId($dto->config_id)->withTrashed()->first();
        if (! $model) {
            $model = new ContactWay(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $model->reset();
        $dto->fill($model);
        $model->saveRestore();

        return $model;
    }

    /**
     * 更新客户联系「联系我」方式
     * @note update
     * @param  UpdateDto  $dto
     * @return ContactWay|null
     *
     * @author eva
     *
     * */
    public static function update(UpdateDto $dto): ?ContactWay
    {
        $model = ContactWay::withCorpId()->whereConfigId($dto->config_id)->withTrashed()->first();
        if (! $model) {
            return null;
        }
        $dto->fill($model->reset());
        $model->saveRestore();

        return $model;
    }

    /**
     * 删除企业已配置的「联系我」方式
     * @note delete
     * @param  string  $config_id
     * @return void
     *
     * @author eva
     *
     * */
    public static function delete(string $config_id): void
    {
        ContactWay::withCorpId()->whereConfigId($config_id)->delete();
    }

    /**
     * @note 创建入参检测
     * @param  array  $data
     * @return CreateDto
     * @throws Exception
     * @author eva
     *
     * */
    public static function checkCreateParams(array $data): CreateDto
    {
        return new CreateDto($data);
    }

    /**
     * @note 更新入参检测
     * @param  array  $data
     * @return UpdateDto
     * @throws Exception
     * @author eva
     *
     * */
    public static function checkUpdateParams(array $data): UpdateDto
    {
        return new UpdateDto($data);
    }
}
