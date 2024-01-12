<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact;

use Buqiu\EnterpriseWechat\Utils\Utils;

class Remark
{
    /**
     * 企业成员的 userid.
     */
    public ?string $userId = null;

    /**
     * 外部联系人 userid.
     */
    public ?string $externalUserId = null;

    /**
     * 此用户对外部联系人的备注，最多20个字符.
     */
    public ?string $remark = null;

    /**
     * 此用户对外部联系人的描述，最多150个字符.
     */
    public ?string $description = null;

    /**
     * 此用户对外部联系人备注的所属公司名称，最多20个字符.
     */
    public ?string $remarkCompany = null;

    /**
     * 此用户对外部联系人备注的手机号.
     */
    public ?array $remarkMobiles = null;

    /**
     * 备注图片的mediaid.
     */
    public ?string $remarkPicMediaId = null;

    /**
     * @note 校验参数
     * @author eva
     *
     * @param  Remark     $remark
     * @throws \Exception
     */
    public static function checkRemarkArgs(Remark $remark)
    {
        Utils::checkNotEmptyStr($remark->userId, 'userid');

        Utils::checkNotEmptyStr($remark->externalUserId, 'external_userid');
    }

    /**
     * @note 处理参数
     * @author eva
     *
     * @param  Remark $remark
     * @return array
     */
    public static function handleRemarkArgs(Remark $remark): array
    {
        $args = [];

        Utils::setIfNotNull($remark->userId, 'userid', $args);
        Utils::setIfNotNull($remark->externalUserId, 'external_userid', $args);
        Utils::setIfNotNull($remark->remark, 'remark', $args);
        Utils::setIfNotNull($remark->description, 'description', $args);
        Utils::setIfNotNull($remark->remarkCompany, 'remark_company', $args);
        Utils::setIfNotNull($remark->remarkMobiles, 'remark_mobiles', $args);
        Utils::setIfNotNull($remark->remarkPicMediaId, 'remark_pic_mediaid', $args);

        return $args;
    }
}
