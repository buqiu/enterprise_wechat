<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback;

use Buqiu\EnterpriseWechat\Contracts\CallBackAbstract;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;

class UploadMediaJobFinish extends CallBackAbstract
{
    public function uploadMediaJobFinish(): void
    {
        EnterpriseWechatFacade::media()->getUploadByUrlResult($this->data['job_id']);
    }
}
