<?php
/**
 * 精度计算类
 */
namespace Gop\Tools;

class Count
{
    public function construct()
    {

    }

    public static function math($left = 0, $symbol = '+', $right = 0, $default = 2)
    {
        //设置全局保留的位数
        bcscale($default);

        switch ($symbol) {
            case '+':
                $res = bcadd(floatval($left), floatval($right));
                break;
            case '-':
                $res = bcsub(floatval($left), floatval($right));
                break;
            case '*':
                $res = bcmul(floatval($left), floatval($right));
                break;
            case '/':
                $res = bcdiv(floatval($left), floatval($right));
                break;
            case '%':
                $res = bcmod(floatval($left), floatval($right));
                break;
            default:
                $res = 0;
                break;
        }
        // 直接返回浮点类型
        return floatval($res);
    }
}