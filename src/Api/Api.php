<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use Buqiu\EnterpriseWechat\Enums\ExceptionCode;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

/**
 * @method static get
 * @method static create
 * @method static update
 * @method static delete
 * @method static batchDelete
 * @method static getFollowUserList
 * @method static list
 * @method static listId
 * @method static getToken
 * @method static addTagUsers
 * @method static delTagUsers
 * @method static verifyUrl
 * @method static notify
 * @method static authorize
 * @method static getUserInfo
 * @method static getUserDetail
 * @method static sso
 * @method static getTfaInfo
 * @method static tfaSuccess
 * @method static authSuccess
 * @method static batchGetByUser
 * @method static remark
 * @method static transferCustomer
 * @method static transferResult
 * @method static resignedTransferResult
 * @method static resignedTransferCustomer
 * @method static mark
 * @method static send
 * @method static recall
 * @method static addMsgTemplate
 * @method static remindMsgSend
 * @method static cancelMsgSend
 * @method static upload
 * @method static uploadImg
 * @method static uploadByUrl
 * @method static getUploadByUrlResult
 * @method static welcome
 * @method static getRange
 * @method static edit
 * @method static addTemplate
 * @method static editTemplate
 * @method static getTemplate
 * @method static delTemplate
 * @method static getTag
 * @method static addTag
 * @method static editTag
 * @method static delTag
 * @method static onJobTransfer
 * @method static resignedTransfer
 * @method static getResult
 * @method static cancelSend
 */
class Api
{
    protected string $baseUri = 'https://qyapi.weixin.qq.com';

    /**
     * Http client.
     */
    protected ?Client $httpClient = null;

    /**
     * Return http client.
     */
    public function getHttpClient(): ClientInterface
    {
        if (! ($this->httpClient instanceof ClientInterface)) {
            $this->httpClient = new Client(['base_uri' => $this->baseUri, 'verify' => false, 'headers' => ['Accept' => 'application/json']]);
        }

        return $this->httpClient;
    }

    /**
     * Request Api
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function request($url, $method = 'GET', $options = []): array
    {
        $method = strtoupper($method);

        $response = $this->getHttpClient()->request($method, $url, $options);

        return $this->response($response);
    }

    /**
     * Http Get
     *
     * @throws GuzzleException
     */
    public function httpGet($url, array $query = []): array
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * Http Post
     *
     * @throws GuzzleException
     */
    public function httpPost(string $url, array $query = [], array $data = []): array
    {
        return $this->request($url, 'POST', ['query' => $query, 'form_params' => $data]);
    }

    /**
     * Http Post Json
     *
     * @throws GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = []): array
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * Http File
     *
     * @throws GuzzleException
     */
    public function httpMultipart(string $url, array $data = [], array $query = []): array
    {
        $data['name'] = $data['name'] ?? 'media';

        if (is_string($data['contents'])) {
            $data['contents'] = Utils::tryFopen($data['contents'], 'r');
        }

        return $this->request($url, 'POST', ['query' => $query, 'multipart' => [$data]]);
    }

    /**
     * Http File Storage
     *
     * @throws GuzzleException
     */
    public function httpFile(string $url, mixed $resource = null, array $query = []): mixed
    {
        $option = ['query' => $query];

        if ($resource) {
            $option['sink'] = $resource;
        }

        return $this->request($url, 'GET', $option);
    }

    /**
     * 数据响应
     *
     * @throws Exception
     */
    protected function response(Response $response)
    {
        $contents = $response->getBody()->getContents();

        if ($response->getStatusCode() !== 200) {
            throw new Exception($contents, $response->getStatusCode());
        }

        $contents = mb_convert_encoding($contents, 'UTF-8', 'auto');

        $result = json_decode($contents, true);

        if (empty($result) || ! is_array($result)) {
            LogHelper::api($contents);

            throw new Exception($contents, ExceptionCode::API_CODE->value);
        }

        if (isset($result['errcode']) && $result['errcode']) {
            throw new Exception($result['errmsg'], $result['errcode']);
        }

        return $result;
    }

    /**
     * 合并 Token
     */
    public function mergeTokenData($data = []): array
    {
        return array_merge([
            'access_token' => EnterpriseWechatFacade::accessToken()->getToken(),
        ], $data);
    }
}
