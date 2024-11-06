<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Media\MediaUrlDto;
use Buqiu\EnterpriseWechat\Dto\MediaDto;
use Exception;

class MediaService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): MediaDto
    {
        return new MediaDto($data);
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkUploadByUrlParams(array $data): MediaUrlDto
    {
        return new MediaUrlDto($data);
    }

    /**
     * 上传文件
     */
    public static function upload(MediaDto $mediaDto): void
    {
        SyncService::media($mediaDto);
    }

    /**
     * 上传文件
     */
    public static function uploadImg(string $url, MediaDto $mediaDto): void
    {
        $mediaDto->setUrl($url);

        SyncService::media($mediaDto);
    }

    /**
     * 异步上传文件
     */
    public static function uploadUrl(string $job_id, MediaUrlDto $mediaUrlDto): void
    {
        $mediaUrlDto->setJobid($job_id);

        SyncService::mediaUrl($mediaUrlDto);
    }

    /**
     * 查询异步任务结果
     *
     * @throws Exception
     */
    public static function syncUploadByUrlResult(string $job_id, int $status, array $data): void
    {
        $mediaUrlDto = new MediaUrlDto($data);
        $mediaUrlDto->setJobid($job_id);
        $mediaUrlDto->setStatus($status);
        SyncService::mediaUrlResult($mediaUrlDto);
    }
}
