<?php
/**
 * Created by PhpStorm.
 * User: wj992
 * Date: 2018/3/14
 * Time: 20:16
 */
use yii\helpers\VarDumper;
if (!function_exists('dd')) {
    function dd($param)
    {
        foreach ($param as $p)  {
            VarDumper::dump($p, 10, true);
            echo '<pre>';
        }
        exit(1);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (('"' === substr($value, 0, 1)) && ('"' === substr($value, -1, 1))) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}