<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Media extends Api
{
    /**
     * 上传临时素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/90253
     *
     * @throws GuzzleException
     */
    public function upload(string $type, mixed $contents, string $filename): array
    {
        return $this->httpMultipart('/cgi-bin/media/upload', compact('contents', 'filename'), $this->mergeTokenData(compact('type')));
    }

    /**
     * 上传图片
     *
     * @link https://developer.work.weixin.qq.com/document/path/90256
     *
     * @throws GuzzleException
     */
    public function uploadImg(mixed $contents, string $filename): string
    {
        $result = $this->httpMultipart('cgi-bin/media/uploadimg', compact('contents', 'filename'), $this->mergeTokenData());

        return $result['url'];
    }

    /**
     * 获取临时素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/90254
     *
     * @throws GuzzleException
     */
    public function get(string $media_id, mixed $resource = null): string
    {
        $result = $this->httpFile('cgi-bin/media/get', $resource, $this->mergeTokenData(compact('media_id')));

        return $result['url'];
    }

    /**
     * 获取高清语音素材
     *
     * @link https://developer.work.weixin.qq.com/document/path/90255
     *
     * @throws GuzzleException
     */
    public function getJsSdk(string $media_id, mixed $resource = null): mixed
    {
        return $this->httpFile('cgi-bin/media/get/jssdk', $resource, $this->mergeTokenData(compact('media_id')));
    }

    /**
     * 生成异步上传任务
     *
     * @link https://developer.work.weixin.qq.com/document/path/90255
     *
     * @throws GuzzleException
     */
    public function uploadByUrl(array $data): string
    {
        $result = $this->httpPostJson('cgi-bin/media/upload_by_url', $data, $this->mergeTokenData());

        return $result['jobid'];
    }

    /**
     * 查询异步任务结果
     *
     * @link https://developer.work.weixin.qq.com/document/path/90255
     *
     * @throws GuzzleException
     */
    public function getUploadByUrlResult(string $jobid): array
    {
        $result = $this->httpPostJson('cgi-bin/media/get_upload_by_url_result', compact('jobid'), $this->mergeTokenData());

        return [$result['status'], $result['detail']];
    }
}
