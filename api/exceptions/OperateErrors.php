<?php
namespace api\exceptions;

/**
 * 错误码模型
 */
abstract class OperateErrors
{
    /**
     * 预定义错误信息
     */
    public static $errors = [
        '000000' => '成功',
        '100003' => "验证过于频繁,请30秒后重试",
    ];

    /**
     * 获取错误信息
     */
    public static function getMessage($code)
    {
        $message = isset(self::$errors[$code]) ? self::$errors[$code] : '未知错误';
        return $message;
    }
}
