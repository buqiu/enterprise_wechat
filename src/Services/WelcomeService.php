<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Message\WelcomeMessageDto;
use Buqiu\EnterpriseWechat\Dto\WelcomeTemplateDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Message;
use Exception;

class WelcomeService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): WelcomeMessageDto
    {
        return new WelcomeMessageDto($data);
    }

    /**
     * 发送应用消息
     *
     * @throws Exception
     */
    public static function send(string $welcome_code, WelcomeMessageDto $welcomeMessageDto): Message
    {
        $welcomeMessageDto->setWelcomeCode($welcome_code);

        return SyncService::welcomeMessage($welcomeMessageDto);
    }

    /**
     * 检测模板入参(新建)
     *
     * @throws Exception
     */
    public static function checkTemplateCreateParams(array $data): WelcomeTemplateDto
    {
        return new WelcomeTemplateDto($data);
    }

    /**
     * 添加入群欢迎语素材
     *
     * @throws Exception
     */
    public static function addTemplate(string $templateId, WelcomeTemplateDto $welcomeTemplateDto): void
    {
        $welcomeTemplateDto->setTemplateId($templateId);

        SyncService::welcomeTemplate($welcomeTemplateDto);
    }

    /**
     * 编辑入群欢迎语素材
     *
     * @throws Exception
     */
    public static function editTemplate(WelcomeTemplateDto $welcomeTemplateDto): void
    {
        SyncService::welcomeTemplate($welcomeTemplateDto);
    }

    /**
     * 获取入群欢迎语素材
     *
     * @throws Exception
     */
    public static function getTemplate(string $templateId, array $data): void
    {
        $welcomeTemplate = new WelcomeTemplateDto($data);

        $welcomeTemplate->setTemplateId($templateId);

        SyncService::welcomeTemplate($welcomeTemplate);
    }

    /**
     * 删除入群欢迎语素材
     *
     * @throws Exception
     */
    public static function delTemplate(string $templateId): void
    {
        SyncService::deleteWelcomeTemplate($templateId);
    }
}
