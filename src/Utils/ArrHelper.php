<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ParamsError;
use Exception;

class ArrHelper
{
    public static function isEmpty($arr, $keys): bool
    {
        $keys = is_array($keys) ? $keys : [$keys];
        foreach ($keys as $key) {
            if (! isset($arr[$key]) || Utils::empty($arr[$key])) {
                return true;
            }
        }

        return false;
    }

    public static function notEmpty($arr, $keys): bool
    {
        return ! ArrHelper::isEmpty($arr, $keys);
    }

    /**
     * 检测数组KEYS是否为空
     *
     * @throws Exception
     */
    public static function validatorEmpty($arr, $keys): void
    {
        $err = [];
        foreach ($keys as $key) {
            if (ArrHelper::isEmpty($arr, $key)) {
                $err[] = $key;
            }
        }

        if ($err) {
            throw new Exception(implode(',', $err).': '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }
    }

    /**
     * 过滤数组空KEYS
     */
    public static function filterArr($arr, $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            if (! Utils::empty($arr[$key])) {
                $result[$key] = $arr[$key];
            }
        }

        return $result;
    }


    /**
     * 数据类型转换
     *
     * @param  array  $arr
     * @return array
     */
    public static function coverType(array $arr): array
    {
        foreach ($arr as $key => $value) {
            if (is_numeric($value)) {
                $arr[$key] = (int) $value;
            }
        }

        return $arr;
    }
}
