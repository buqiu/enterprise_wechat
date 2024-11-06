<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Exceptions\ParameterError;

class Utils
{
    public static function empty($var): bool
    {
        return ! isset($var) || $var === '' || $var === [] || $var === false;
    }

    public static function notEmpty($var): bool
    {
        return ! self::empty($var);
    }

    public static function arrayFilter(array $data, $value = null): array
    {
        return array_filter($data, function ($item) use ($value) {
            if (is_array($value)) {
                return ! in_array($item, $value);
            } else {
                return $value ? ($item !== $value) : ($item !== null && $item !== '');
            }
        });
    }

    public static function notEmptyStr($var): bool
    {
        return is_string($var) && ($var != '');
    }

    /**
     * @throws ParameterError
     */
    public static function checkNotEmptyStr($var, $name): void
    {
        if (! self::notEmptyStr($var)) {
            throw new ParameterError($name.' can not be empty string');
        }
    }

    /**
     * @throws ParameterError
     */
    public static function checkIsUInt($var, $name): void
    {
        if (! (is_int($var) && $var >= 0)) {
            throw new ParameterError($name.' need unsigned int');
        }
    }

    /**
     * @throws ParameterError
     */
    public static function checkNotEmptyArray($var, $name): void
    {
        if (! is_array($var) || count($var) == 0) {
            throw new ParameterError($name.' can not be empty array');
        }
    }

    public static function setIfNotNull($var, $name, &$args): void
    {
        if (! is_null($var)) {
            $args[$name] = $var;
        }
    }

    public static function arrayGet($array, $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }

    /**
     * 数组 转 对象
     *
     * @param  array  $arr  数组
     * @return object|array
     */
    public function Array2Object(array $arr): object|array
    {
        if (gettype($arr) != 'array') {
            return $arr;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || gettype($v) == 'object') {
                $arr[$k] = (object) self::Array2Object($v);
            }
        }

        return (object) $arr;
    }

    /**
     * 对象 转 数组
     *
     * @param  $object
     * @return array
     */
    public function Object2Array($object): array
    {
        if (is_object($object) || is_array($object)) {
            $array = [];
            foreach ($object as $key => $value) {
                if ($value == null) {
                    continue;
                }
                $array[$key] = self::Object2Array($value);
            }

            return $array;
        } else {
            return $object;
        }
    }

    //数组转XML
    public function Array2Xml($rootName, $arr): string
    {
        $xml = '<'.$rootName.'>';
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= '<'.$key.'>'.$val.'</'.$key.'>';
            } else {
                $xml .= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
            }
        }
        $xml .= '</'.$rootName.'>';

        return $xml;
    }

    //将XML转为array
    public static function Xml2Array($xml): array
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}
