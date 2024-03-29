<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ParamsError;

class Utils
{
    // 字符串不为空
    public static function notEmptyStr($var): bool
    {
        return !empty($var);
    }

    // 数组不为空
    public static function notEmptyArr($var): bool
    {
        return !empty($var) && is_array($var);
    }

    // 字符串不能为空
    public static function checkNotEmptyStr($var, $name)
    {
        if (!self::notEmptyStr($var)) {
            throw new \Exception($name.' '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }
    }

    // 数组不能为空
    public static function checkNotEmptyArray($var, $name)
    {
        if (!self::notEmptyArr($var)) {
            throw new \Exception($name.': '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }
    }

    /**
     * @param $args
     * @throws \Exception
     */
    public static function checkAllEmptyArray($args)
    {
        $count = count($args);
        $i     = 0;
        $err   = [];
        foreach ($args as $name => $val) {
            try {
                self::checkNotEmptyArray($val, $name);
            } catch (\Exception $e) {
                $err[] = $name;
                ++$i;
            }
        }

        if ($count == $i) {
            throw new \Exception(implode(',', $err).': '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
        }
    }

    public static function setIfNotNull($var, $name, &$args)
    {
        if (!is_null($var)) {
            $args[$name] = $var;
        }
    }

    public static function arrayIsExist($array, $key, $default = null)
    {
        if (!self::notEmptyArr($array)) {
            return $default;
        }

        return $array[$key] ?? $default;
    }

    // 将 XML 转为 Array
    public static function xmlToArray($xml)
    {
        // 禁止引用外部 XML 实体
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}
