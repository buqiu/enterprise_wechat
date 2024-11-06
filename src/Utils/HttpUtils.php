<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Exceptions\HttpError;
use Buqiu\EnterpriseWechat\Exceptions\InternalError;
use Buqiu\EnterpriseWechat\Exceptions\NetWorkError;
use Exception;

class HttpUtils
{
    const BASE = 'https://qyapi.weixin.qq.com';

    public static function makeUrl($queryArgs): string
    {
        if (substr($queryArgs, 0, 1) === DIRECTORY_SEPARATOR) {
            return self::BASE.$queryArgs;
        }

        return self::BASE.DIRECTORY_SEPARATOR.$queryArgs;
    }

    public static function array2Json($arr): string
    {
        $parts     = [];
        $isList    = false;
        $keys      = array_keys($arr);
        $maxLength = count($arr) - 1;

        if ($maxLength > 0 && ($keys[0] === 0) && ($keys[$maxLength] === $maxLength)) {
            $isList = true;
            for ($i = 0; $i < count($keys); $i++) {
                if ($i != $keys[$i]) {
                    $isList = false;
                    break;
                }
            }
        }

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                if ($isList) {
                    $parts[] = self::array2Json($value);
                } else {
                    $parts[] = '"'.$key.'":'.self::array2Json($value);
                }
            } else {
                $str = '';
                if (! $isList) {
                    $str = '"'.$key.'":';
                }
                if (! is_string($value) && is_numeric($value) && $value < 2000000000) {
                    $str .= $value;
                } elseif ($value === false) {
                    $str .= 'false';
                } elseif ($value === true) {
                    $str .= 'true';
                } else {
                    $str .= '"'.addcslashes($value, "\\\"\n\r\t/").'"';
                }
                $parts[] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($isList) {
            return '['.$json.']';
        }

        return '{'.$json.'}';
    }

    /**
     * http get
     *
     * @throws Exception
     */
    public static function httpGet($url): bool|string
    {
        self::__checkDeps();
        $ch = curl_init();

        self::__setSSLOpts($ch, $url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return self::__exec($ch);
    }

    /**
     * http post
     *
     * @param  $url
     * @param  $postData
     * @return bool|string
     * @throws HttpError|NetWorkError|InternalError
     */
    public static function httpPost($url, $postData): bool|string
    {
        self::__checkDeps();
        $ch = curl_init();
        self::__setSSLOpts($ch, $url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        return self::__exec($ch);
    }

    private static function __setSSLOpts($ch, $url): void
    {
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }
    }

    private static function __exec($ch): bool|string
    {
        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);

        if ($output === false) {
            throw new NetWorkError('network error');
        }

        if (intval($status['http_code']) != 200) {
            throw new HttpError('unexpected http code '.intval($status['http_code']));
        }

        return $output;
    }

    /**
     * 校验 curl_init 是否存在
     *
     * @throws InternalError
     */
    private static function __checkDeps(): void
    {
        if (! function_exists('curl_init')) {
            throw new InternalError('missing curl extend');
        }
    }
}
