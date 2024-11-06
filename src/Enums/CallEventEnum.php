<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Enums;

enum CallEventEnum: string
{
    case CHANGE_CONTACT                 = 'change_contact';
    case CHANGE_EXTERNAL_CONTACT        = 'change_external_contact';
    case CHANGE_EXTERNAL_TAG            = 'change_external_tag';
    case CHANGE_EXTERNAL_CHAT           = 'change_external_chat';
    case CHANGE_UPLOAD_MEDIA_JOB_FINISH = 'upload_media_job_finish';

    public static function exist(string $event): bool
    {
        return match ($event) {
            self::CHANGE_CONTACT->value,
            self::CHANGE_EXTERNAL_CONTACT->value,
            self::CHANGE_EXTERNAL_TAG->value,
            self::CHANGE_EXTERNAL_CHAT->value,
            self::CHANGE_UPLOAD_MEDIA_JOB_FINISH->value, => true,
            default => false,
        };
    }
}
