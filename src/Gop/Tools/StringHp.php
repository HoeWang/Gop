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

    public function __construct()
    {

    }

    /**
     * 清除首尾空格
     * @param $str
     * @return string
     */
    public static function trimSpace($str)
    {
        return trim(trim($str, chr(0xc2) . chr(0xa0)));
    }

    /**
     * 是否是中文字符
     * @param string $str 单个字符
     * @return bool
     */
    public static function isChinese(string $str = '')
    {
        preg_match_all('/[\x{4e00}-\x{9fa5}]/u', $str, $matches);
        return !empty($matches[0]) ? true : false;
    }


    /**
     * 过滤不能作为sheetName的字符
     */
    public static function filterExcelSheet($str, $length = 0)
    {
        if ($length) {
            $str = mb_substr(str_replace(['*', ':', '/', '\\', '?', '[', ']', '='], '', $str), 0, $length);
        } else {
            $str = str_replace(['*', ':', '/', '\\', '?', '[', ']', '='], '', $str);
        }

        if (empty($str)) {
            return '-';
        }
        return $str;
    }

    public static function reeChar($strParam)
    {
        $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\=|\\\|\|／|の|/";
        $spaceChar = [chr(0xc2) . chr(0xa0), "　", "\t", "\n", "\r"];

        $cv = preg_replace($regex, "", $strParam);

        return str_replace($spaceChar, '', $cv);
    }

    /**
     * 截取描述长度 ( 中文按 2 位计算，跟前端保持统一)
     * @param $descStr
     * @param int $limitLen
     * @return string
     */
    public static function subDescLen($descStr, $limitLen = 30)
    {
        $descArr = preg_split('/(?<!^)(?!$)/u', $descStr);

        $desc = '';
        $len = 0;
        foreach ($descArr as $str) {
            $len++;
            if (preg_match('/[\x7f-\xff]/', $str)) {
                $len++;
            }
            if ($len == $limitLen) {
                return $desc . $str;
            } elseif ($len > $limitLen) {
                return $desc;
            }
            $desc .= $str;
        }

        return $desc;
    }

    /**
     * 计算字符总长度
     * @param $str
     * @param int $ccLen 一个中文字符按几位计算，默认3位
     * @param int $uppercaseLen 一个大写字母按几位字符计算，默认1位
     * @return int
     */
    public static function getLength($str, int $ccLen = 3, int $uppercaseLen = 1)
    {
        $strGroup = preg_split('/(?<!^)(?!$)/u', $str);

        $len = 0;
        foreach ($strGroup as $strItem) {
            if (self::isChinese($strItem)) {
                $len += $ccLen;
            } else {
                $matches = [];
                preg_match('/[A-Z]/', $strItem, $matches);
                $len += $matches ? $uppercaseLen : 1;
            }
        }

        return $len;
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

    /**
     * 取出所有的中文字符串进行相关拼接
     * Auth: baiwei
     * DateTime: 2021/2/6
     * @param $text
     * @return string
     */
    public static function subText($text)
    {
        preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $text, $content);
        $datas = $content[0] ?? [];

        foreach ($datas as $key => $data) {
            if (strpos($data, '参考') !== false) {
                unset($datas[$key]);
            }
        }

        $string = implode(',', $datas);

        return $string;
    }
}