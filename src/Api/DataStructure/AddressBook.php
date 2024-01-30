<?php

declare(strict_types=1);

/**
 * @note   AddressBook${CARET}
 * @author Lu
 */

namespace Buqiu\EnterpriseWechat\Api\DataStructure;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ApiError;
use Buqiu\EnterpriseWechat\Utils\HttpUtils;
use Buqiu\EnterpriseWechat\Utils\Utils;

class AddressBook
{
    // 获取所有部门
    public const DEPARTMENT_URL = 'https://qyapi.weixin.qq.com/cgi-bin/department/list';

    // 获取部门下的成员
    public const USER_SIMPLE_URL = 'https://qyapi.weixin.qq.com/cgi-bin/user/simplelist';
    // 获取用户唯一标识
    public const USER_INFO_URL = 'https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo';
    // 获取部门下成员的详情信息
    public const USER_SIMPLE_DETAIL_URL = 'https://qyapi.weixin.qq.com/cgi-bin/user/list';

    // 网页授权，获取用户信息
    public const H5_AUTH_USERINFO = 'https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo';

    // 获取访问用户敏感信息
    public const AUTH_USER_DETAIL = 'https://qyapi.weixin.qq.com/cgi-bin/auth/getuserdetail';

    // 读取成员
    public const CGI_BIN_USER = 'https://qyapi.weixin.qq.com/cgi-bin/user/get';

    // 更新部门
    public const UPDATE_USER = 'https://qyapi.weixin.qq.com/cgi-bin/user/update';

    // 获取待分配的离职成员列表
    public const UNASSIGNED_URL = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_unassigned_list';

    /**
     * @note   getDepartmentList 获取所有部门
     * @author Lu
     *
     * @param $token
     * @param  int        $departmentId
     * @return mixed
     * @throws \Exception
     */
    public static function getDepartmentList($token, int $departmentId = 0)
    {
        $parameter = '?access_token='.$token;
        if (0 != $departmentId) {
            $parameter .= '&id='.$departmentId;
        }

        $result = HttpUtils::httpGet(self::DEPARTMENT_URL.$parameter);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   getUserSimpleList 获取部门下的成员
     * @author Lu
     *
     * @param             $token
     * @param  int        $departmentId
     * @return mixed
     * @throws \Exception
     */
    public static function getUserSimpleList($token, int $departmentId = 0)
    {
        $parameter = '?access_token='.$token;
        if (0 != $departmentId) {
            $parameter .= '&department_id='.$departmentId;
        }
        $result = HttpUtils::httpGet(self::USER_SIMPLE_URL.$parameter);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   getUserSimpleDetailList 获取部门下的详情成员
     * @author Lu
     *
     * @param             $token
     * @param  int        $departmentId
     * @return mixed
     * @throws \Exception
     */
    public static function getUserSimpleDetailList($token, int $departmentId = 0)
    {
        $parameter = '?access_token='.$token;
        if (0 != $departmentId) {
            $parameter .= '&department_id='.$departmentId;
        }
        $result = HttpUtils::httpGet(self::USER_SIMPLE_DETAIL_URL.$parameter);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   getUserAuth web端，扫码获取用户信息
     * @author Lu
     *
     * @param $token
     * @param $code
     * @return mixed
     * @throws \Exception
     */
    public static function getUserAuth($token, $code)
    {
        $result = HttpUtils::httpGet(self::USER_INFO_URL.'?access_token='.$token.'&code='.$code);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   h5AuthUserInfo h5 授权获取用户信息
     * @author Lu
     *
     * @param $token
     * @param $code
     * @return mixed
     * @throws \Exception
     */
    public static function h5AuthUserInfo($token, $code)
    {
        $result = HttpUtils::httpGet(self::H5_AUTH_USERINFO.'?access_token='.$token.'&code='.$code);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   h5AuthUserDetail h5 授权获取用户敏感信息
     * @author Lu
     *
     * @param $token
     * @param $userTicket
     * @return mixed
     * @throws \Exception
     */
    public static function h5AuthUserDetail($token, $userTicket)
    {
        $url = self::AUTH_USER_DETAIL.'?access_token='.$token;

        $result = HttpUtils::httpPost($url, ['user_ticket' => $userTicket]);
        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   getUserInfoById 通过用户id，读取用户信息
     * @author Lu
     *
     * @param $token
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public static function getUserInfoById($token, $userId)
    {
        $result = HttpUtils::httpGet(self::CGI_BIN_USER.'?access_token='.$token.'&userid='.$userId);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   setUserDepartment 更新用户部门
     * @author Lu
     *
     * @param $token
     * @param $userId
     * @param $departmentArr
     * @return mixed
     * @throws \Exception
     */
    public static function setUserDepartment($token, $userId, $departmentArr)
    {
        $result = HttpUtils::httpPost(self::UPDATE_USER.'?access_token='.$token, [
            'userid'     => $userId,
            'department' => $departmentArr,
        ]);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }

    /**
     * @note   getUnassignedList 获取待分配的离职成员列表
     * @author Lu
     *
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public static function getUnassignedList($token)
    {
        $result = HttpUtils::httpPost(self::UNASSIGNED_URL.'?access_token='.$token, []);

        if (!Utils::notEmptyStr($result)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
        }

        return json_decode($result, true);
    }
}
