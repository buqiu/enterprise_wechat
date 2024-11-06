<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\MediaService;
use Exception;

class Media extends Lib
{
    /**
     * 上传临时素材
     *
     * @throws Exception
     */
    public function upload(array $data): array
    {
        $mediaDto = MediaService::checkCreateParams($data);

        $result = $this->api->upload($mediaDto->getType(), $mediaDto->getContents(), $mediaDto->getFileName());

        $mediaDto->setData($result);

        MediaService::upload($mediaDto);

        return $result;
    }

    /**
     * 上传图片
     *
     * @throws Exception
     */
    public function uploadImg(array $data): string
    {
        $mediaDto = MediaService::checkCreateParams($data);

        $url = $this->api->uploadImg($mediaDto->getType(), $mediaDto->getContents(), $mediaDto->getFileName());

        MediaService::uploadImg($url, $mediaDto);

        return $url;
    }

    /**
     * 异步上传临时素材
     *
     * @throws Exception
     */
    public function uploadByUrl(array $data): void
    {
        $mediaDto = MediaService::checkUploadByUrlParams($data);

        $jobId = $this->api->uploadByUrl($mediaDto->getData());

        MediaService::uploadUrl($jobId, $mediaDto);
    }


    /**
     * 查询异步任务结果
     *
     * @throws Exception
     */
    public function getUploadByUrlResult(string $job_id): void
    {
        [$status, $data] = $this->api->getUploadByUrlResult($job_id);

        MediaService::syncUploadByUrlResult($job_id, $status, $data);
    }
}
