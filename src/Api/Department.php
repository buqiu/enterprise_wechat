<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Department extends Api
{
    /**
     * 获取所有部门
     *
     * @link https://developer.work.weixin.qq.com/document/path/90208
     *
     * @throws GuzzleException
     */
    public function list(?int $id = null): array
    {
        $result = $this->httpGet('cgi-bin/department/list', $this->mergeTokenData(compact('id')));

        return $result['department'] ?? [];
    }

    /**
     * 获取子部门ID列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/95350
     *
     * @throws GuzzleException
     */
    public function simpleList(?int $id = null): array
    {
        $result = $this->httpGet('cgi-bin/department/simplelist', $this->mergeTokenData(compact('id')));

        return $result['department_id'] ?? [];
    }

    /**
     * 获取单个部门详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/95351
     *
     * @throws GuzzleException
     */
    public function get(int $id): array
    {
        $result = $this->httpGet('cgi-bin/department/get', $this->mergeTokenData(compact('id')));

        return $result['department'] ?? [];
    }

    /**
     * 创建部门
     *
     * @link https://developer.work.weixin.qq.com/document/path/90205
     *
     * @throws GuzzleException
     */
    public function create(array $data): int
    {
        $result = $this->httpPostJson('cgi-bin/department/create', $data, $this->mergeTokenData(['']));

        return $result['id'];
    }

    /**
     * 更新部门
     *
     * @link https://developer.work.weixin.qq.com/document/path/90206
     *
     * @throws GuzzleException
     */
    public function update(array $data): int
    {
        $this->httpPostJson('cgi-bin/department/update', $data, $this->mergeTokenData());

        return $data['id'];
    }

    /**
     * 删除部门
     *
     * @link https://developer.work.weixin.qq.com/document/path/90207
     *
     * @throws GuzzleException
     */
    public function delete(int $id): int
    {
        $this->httpGet('cgi-bin/department/delete', $this->mergeTokenData(compact('id')));

        return $id;
    }
}
