<?php
namespace api\helpers;

/**
 * 自定义函数
 */
class ExtendFunction
{
    /**
     * 数组转换字符串
     * @param  array    $array 数组
     * @param  string   $glue  字符
     * @return string
     */
    public static function array2str($array, $glue)
    {
        $str = '';
        foreach ($array as $key => $value) {
            $str .= $key . '=' . $value . $glue;
        }
        $str = substr($str, 0, -1);
        return $str;
    }

    /**
     * 数据过滤(程序返回结果都为string)
     */
    public static function _safeData($data)
    {
        if ($data) {
            if (is_array($data)) {
                $temp = [];
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $temp[$key] = self::_safeData($value);
                    } elseif (is_string($value)) {
                        $temp[$key] = htmlspecialchars(addslashes($value));
                    } else {
                        $temp[$key] = htmlspecialchars(addslashes((string) $value));
                    }
                }
            } else {
                $temp = htmlspecialchars(addslashes($data));
            }
        } else {
            $temp = [];
        }
        return $temp;
    }

    /**
     * 数据过滤(程序返回保留原本类型)
     */
    public static function _safeDataWithType($data)
    {
        if ($data) {
            if (is_array($data)) {
                $temp = [];
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $temp[$key] = self::_safeDataWithType($value);
                    } else {
                        $type=gettype($value);
                        $temp[$key] = htmlspecialchars(addslashes($value));
                        settype($temp[$key],$type);
                    }
                }
            } else {
                $type=gettype($data);
                $temp = htmlspecialchars(addslashes($data));
                settype($temp,$type);
            }
        } else {
            $temp = [];
        }
        return $temp;
    }
}
