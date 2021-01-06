<?php
/**
 * 数组类
 */

namespace Gop\Tools;

class ArrayHp
{
    public function __construct()
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

    /**
     * 根据键名获取键值，重组为新数组
     * @param array $arrays 二维数组
     * @param string $key 键名
     * @return array
     */
    public static function values($arrays = [], $key = null)
    {
        $data = [];
        if (!empty($arrays) && is_array($arrays)) {
            foreach ($arrays as $array) {
                if (is_array($array) && !empty($array[$key])) {
                    $data[] = $array[$key];
                }
            }
        }
        return $data;
    }

    /**
     * 根据键名获取键值
     * @param array $arrays 一维数组
     * @param string|array $key 键名
     * @param mixed $default 默认值
     * @return null|mixed
     */
    public static function value($arrays, $key, $default = null)
    {
        if (empty($arrays) || !is_array($arrays)) {
            return $default;
        }

        if (is_array($key)) {
            foreach ($key as $item) {
                if (!array_key_exists($item, $arrays) || empty($arrays[$item])) {
                    return $default;
                }
                $arrays = $arrays[$item];
            }
            return $arrays;
        } else {
            if (array_key_exists($key, $arrays) && !empty($arrays[$key])) {
                return $arrays[$key];
            } else {
                return $default;
            }
        }
    }

    /**
     * 将第二维数组中的指定键名的键值提到第一维数组中作为键名
     * @param array $array 必须是二维数组
     * @param string $key 指定键名
     * @return array
     */
    public static function index($array = [], $key = null)
    {
        $data = [];
        if ($array && is_array($array)) {
            foreach ($array as $index => $item) {
                if (is_array($item) && array_key_exists($key, $item)) {
                    $data[$item[$key]] = $item;
                }
            }
        }
        return $data;
    }

    /**
     * 数组转XML
     * @param array $array
     * @param string $parent 父级标签名
     * @return string
     */
    public static function xml($array = [], $parent = 'xml')
    {
        $data = '<?xml version="1.0" encoding="utf-8"?>';
        $data .= '<' . $parent . '>';
        $data .= self::array2xml($array);
        $data .= '</' . $parent . '>';
        return $data;
    }

    /**
     * 数组转XML数据处理
     * @param array $array
     * @return string
     */
    private static function array2xml($array = [])
    {
        global $data;
        if ($array) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $data .= '<' . $key . '>';
                    self::xml($value);
                    $data .= '</' . $key . '>';
                } else {
                    $data .= '<' . $key . '>' . $value . '</' . $key . '>';
                }
            }
        }
        return $data;
    }

    /**
     * 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function combine(array $array1 = [], array $array2 = [])
    {
        if (count($array1) == count($array2)) {
            return array_combine($array1, $array2);
        }

        if (empty($array1) && !empty($array2)) {
            return array_values($array2);
        }

        $data = [];
        foreach ($array1 as $key => $value) {
            $data[$value] = $array2[$key] ?? null;
        }

        return $data;
    }

    /**
     * 根据二维数组的某个字段对整个大数组进行排序
     * Auth: baiwei
     * DateTime: 2021/1/6
     * @param array $data
     * @param $columnName
     * @param string $order
     * @return array
     */
    public static function arraySort(array $data, $columnName, $order = 'asc')
    {
        $orderString = SORT_ASC;
        $order == 'desc' && $orderString = SORT_DESC;
        $last_names = array_column($data, $columnName);
        array_multisort($last_names, $orderString, $data);

        return $data;
    }
}