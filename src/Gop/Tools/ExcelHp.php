<?php
/**
 * excel类
 */

namespace Gop\Tools;

class ExcelHp
{
    private static $conn;
    private static $excel;

    public static $config = ['path' => '/tmp/tests/'];

    //防止对象被复制
    public function __clone()
    {
        trigger_error('Clone is not allowed !');
    }

    public function __construct()
    {
        if (!(self::$excel instanceof \Vtiful\Kernel\Excel)) {
            self::$excel = new \Vtiful\Kernel\Excel(self::$config);
        }
    }

    //创建一个用来实例化对象的方法
    public static function getInstance()
    {
        if (!(self::$conn instanceof self)) {
            self::$conn = new self;
        }
        return self::$conn;
    }

    public function outPut(array $herder = [], array $data = [], $fileName = 'test')
    {
        $excel = self::$excel;
        $fileFd = $excel->fileName($fileName . '.xlsx', 'sheet1');
        $setHeader = $fileFd->header($herder);
        $setData = $setHeader->data($data);
        $output = $setData->output();
        var_dump($output);
    }
}