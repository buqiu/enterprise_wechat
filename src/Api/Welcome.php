<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Welcome extends Api
{
    /**
     * 发送新客户欢迎语
     *
     * @link https://developer.work.weixin.qq.com/document/path/92137
     *
     * @throws GuzzleException
     */
    public function send(string $welcome_code, array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/send_welcome_msg', array_merge($data, ['welcome_code' => $welcome_code]), $this->mergeTokenData());
    }

    /**
     * 添加入群欢迎语素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/92366
     *
     * @throws GuzzleException
     */
    public function addTemplate(array $data): string
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/add', $data, $this->mergeTokenData());

        return $result['template_id'];
    }

    /**
     * 编辑入群欢迎语素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/92366
     *
     * @throws GuzzleException
     */
    public function editTemplate(array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/edit', $data, $this->mergeTokenData());
    }

    /**
     * 获取入群欢迎语素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/92366
     *
     * @throws GuzzleException
     */
    public function getTemplate(string $template_id): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/get', compact('template_id'), $this->mergeTokenData());
    }

    /**
     * 获取入群欢迎语素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/92366
     *
     * @throws GuzzleException
     */
    public function delTemplate(string $template_id): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/del', compact('template_id'), $this->mergeTokenData());
    }
}
