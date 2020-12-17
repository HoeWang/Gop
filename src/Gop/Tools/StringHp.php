<?php
/**
 * 字符串类
 */
namespace Gop\Tools;

class StringHp
{
    const TYPE_MOBILE = 'yd';
    const TYPE_UNICOM = 'lt';
    const TYPE_TELECOM = 'dx';

    public function construct()
    {

    }

    /**
     * 检测是否是手机号
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param string $number
     * @return bool
     */
    public static function isMobile($number = '')
    {
        if (preg_match("/^1[0-9]{10}$/", (string)$number)) {
            return true;
        }

        return false;
    }

    /**
     * 获取电话号码的类型
     * @param $mobile
     * @return string
     */
    public static function getTypeByMobile($mobile)
    {
        if (self::ltMobile($mobile)) {
            return self::TYPE_UNICOM;
        } elseif (self::dxMobile($mobile)) {
            return self::TYPE_TELECOM;
        }

        return self::TYPE_MOBILE;
    }

    /**
     * 是否是联通号码
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param $mobile
     * @return bool
     */
    public static function ltMobile($mobile)
    {
        $pattern = '/^1((3[012]|45|5[456]|6[67]|7[156]|8[56])[0-9]|70[789])\d{7}$/';
        return \preg_match($pattern, $mobile) ? true : false;
    }

    /**
     * 是否是电信手机号
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param $mobile
     * @return bool
     */
    public static function dxMobile($mobile)
    {
        $pattern = '/^1((33|49|53|7[379]|8[019]|9[019])[0-9]|700|701)\d{7}$/';
        return \preg_match($pattern, $mobile) ? true : false;
    }
}