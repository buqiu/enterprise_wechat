<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class User extends Api
{
    /**
     * 创建成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90195
     *
     * @throws GuzzleException
     */
    public function create(array $data): array
    {
        return $this->httpPostJson('cgi-bin/user/create', $data, $this->mergeTokenData());
    }

    /**
     * 读取成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90196
     *
     * @throws GuzzleException
     */
    public function get(string $userid): array
    {
        return $this->httpGet('cgi-bin/user/get', $this->mergeTokenData(compact('userid')));
    }

    /**
     * 更新成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90197
     *
     * @throws GuzzleException
     */
    public function update(array $data): array
    {
        return $this->httpPostJson('cgi-bin/user/update', $data, $this->mergeTokenData());
    }

    /**
     * 删除成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90198
     *
     * @throws GuzzleException
     */
    public function delete(string $userid): array
    {
        return $this->httpGet('cgi-bin/user/delete', $this->mergeTokenData(compact('userid')));
    }

    /**
     * 批量删除成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90199
     *
     * @throws GuzzleException
     */
    public function batchDelete(array $useridlist): array
    {
        return $this->httpPostJson('cgi-bin/user/batchdelete', compact('useridlist'), $this->mergeTokenData());
    }

    /**
     * 获取部门成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90200
     *
     * @throws GuzzleException
     */
    public function simpleList(int $department_id): array
    {
        return $this->httpGet('cgi-bin/user/simplelist', $this->mergeTokenData(compact('department_id')));
    }

    /**
     * 获取部门成员详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/90201
     *
     * @throws GuzzleException
     */
    public function list(int $department_id): array
    {
        $result = $this->httpGet('cgi-bin/user/list', $this->mergeTokenData(compact('department_id')));

        return $result['userlist'];
    }

    /**
     * userid与openid互换
     *
     * @link https://developer.work.weixin.qq.com/document/path/90202
     *
     * @throws GuzzleException
     */
    public function convertToOpenid(string $userid): array
    {
        return $this->httpPostJson('cgi-bin/user/convert_to_openid', compact('userid'), $this->mergeTokenData());
    }

    /**
     * openid转userid
     *
     * @link https://developer.work.weixin.qq.com/document/path/90202
     *
     * @throws GuzzleException
     */
    public function convertToUserid(string $openid): array
    {
        return $this->httpPostJson('cgi-bin/user/convert_to_userid', compact('openid'), $this->mergeTokenData());
    }

    /**
     * 手机号获取userid
     *
     * @link https://developer.work.weixin.qq.com/document/path/95402
     *
     * @throws GuzzleException
     */
    public function getUserId(string $mobile): array
    {
        return $this->httpPostJson('cgi-bin/user/getuserid', compact('mobile'), $this->mergeTokenData());
    }

    /**
     * 邮箱获取userid
     *
     * @link https://developer.work.weixin.qq.com/document/path/95895
     *
     * @throws GuzzleException
     */
    public function getUserIdByEmail(string $email, int $email_type = 1): array
    {
        return $this->httpPostJson('cgi-bin/user/get_userid_by_email', compact('email', 'email_type'), $this->mergeTokenData());
    }

    /**
     * 获取成员ID列表
     *
     * @throws GuzzleException
     */
    public function listId(?string $cursor = null, ?int $limit = null): array
    {
        $result = $this->httpPostJson('cgi-bin/user/list_id', compact('cursor', 'limit'), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['dept_user']];
    }

    /**
     * 获取配置了客户联系功能的成员列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/92571
     *
     * @throws GuzzleException
     */
    public function getFollowUserList(): array
    {
        $result = $this->httpGet('cgi-bin/externalcontact/get_follow_user_list', $this->mergeTokenData());

        return $result['follow_user'];
    }
}
