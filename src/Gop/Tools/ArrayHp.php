<?php
/**
 * 数组类
 */
namespace Gop\Tools;

class ArrayHp
{
    public function construct()
    {

    }

    /**
     * 高性能去重
     * Auth: baiwei
     * DateTime: 2020/12/11
     * @param array $arr
     * @return array
     */
    public static function unique(array $arr = [])
    {
        $res = array_values(array_keys(array_flip($arr)));

        return $res;
    }

    /**
     * 高性能in_array
     * Auth: baiwei
     * DateTime: 2020/12/11
     * @param $col
     * @param $arr
     * @return bool
     */
    public static function inArray($col, $arr)
    {
        $res = isset(array_flip($arr)[$col]);

        return $res;
    }

    /**
     * 对象转数组
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param $object
     * @return mixed
     */
    public static function toArray($object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

    /**
     * 数组转对象
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param $object
     * @return mixed
     */
    public static function toObject($array)
    {
        $object = json_decode(json_encode($array));
        return $object;
    }
}