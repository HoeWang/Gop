<?php
/**
 * 加解密类
 */

namespace Gop\Tools;

class Encrypt
{
    public function __construct()
    {

    }

    //加密函数
    public static function lockcode($code)
    {
        static $source_string = 'E5FCDG3HQA4B1NOPIJ2RSTUV67MWX89KLYZ';
        $num = $code;
        $code = '';
        while ($num > 0) {
            $mod = $num % 35;
            $num = ($num - $mod) / 35;
            $code = $source_string[$mod] . $code;
        }
        if (empty($code[3])) {
            $code = str_pad($code, 4, '0', STR_PAD_LEFT);
        }
        return $code;
    }

    //解密函数
    public static function unlockcode($code)
    {
        static $source_string = 'E5FCDG3HQA4B1NOPIJ2RSTUV67MWX89KLYZ';
        if (strrpos($code, '0') !== false) {
            $code = substr($code, strrpos($code, '0') + 1);
        }
        $len = strlen($code);
        $code = strrev($code);
        $num = 0;
        for ($i = 0; $i < $len; $i++) {
            $num += strpos($source_string, $code[$i]) * pow(35, $i);
        }
        return $num;
    }

    /**
     * 加密支持盐值参数
     * encrypt('abcd','1234')=》mZPHxw== decrypt('mZPHxw==','1234')=》abcd
     * Auth: baiwei
     * DateTime: 2020/12/30
     * @param $data
     * @param $key
     * @return string
     */
    public static function encrypt($data, $key)
    {
        $char = "";
        $str = "";
        $key = md5($key);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    public static function decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }

    //discuz加密算法
    public static function authcode($string, $key = '', $operation = false, $expiry = 0)
    {
        $ckey_length = 4;
        $key = md5($key ? $key : '666888');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation ? substr($string, 0, $ckey_length) : substr(md5(microtime()),
            -$ckey_length)) : '';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        $string = $operation ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation) {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}