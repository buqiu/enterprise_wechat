<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\WelcomeService;
use Exception;

class Welcome extends Lib
{
    /**
     * 发送新客户欢迎语
     *
     * @throws Exception
     */
    public function send(string $welcome_code, array $data): void
    {
        $messageDto = WelcomeService::checkCreateParams($data);

        $this->api->send($welcome_code, $messageDto->getParams());

        WelcomeService::send($welcome_code, $messageDto);
    }

    /**
     * 添加入群欢迎语素材
     *
     * @throws Exception
     */
    public function addTemplate(array $data): void
    {
        $messageTemplateDto = WelcomeService::checkTemplateCreateParams($data);

        $templateId = $this->api->addTemplate($messageTemplateDto->getData());

        WelcomeService::addTemplate($templateId, $messageTemplateDto);
    }

    /**
     * 编辑入群欢迎语素材
     *
     * @throws Exception
     */
    public function editTemplate(array $data): void
    {
        $messageTemplateDto = WelcomeService::checkTemplateCreateParams($data);

        $this->api->editTemplate($messageTemplateDto->getData());

        WelcomeService::editTemplate($messageTemplateDto);
    }

    /**
     * 获取入群欢迎语素材
     *
     * @throws Exception
     */
    public function getTemplate(string $template_id): void
    {
        $data = $this->api->getTemplate($template_id);

        WelcomeService::getTemplate($template_id, $data);
    }

    /**
     * 删除入群欢迎语素材
     *
     * @throws Exception
     */
    public function delTemplate(string $template_id): void
    {
        $this->api->delTemplate($template_id);

        WelcomeService::delTemplate($template_id);
    }
}
