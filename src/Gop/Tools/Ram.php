<?php
/**
 * 性能分析类
 */
namespace Gop\Tools;

class Ram
{
    public function construct()
    {

    }

    public static function execMemory(callable $callback)
    {
//        header("Content-type: text/html; charset=utf-8");
        $start = microtime(true);
        // 记录内存初始使用
        define('DD_MEMORY_LIMIT_ON', function_exists('memory_get_usage'));
        if (DD_MEMORY_LIMIT_ON) {
            $GLOBALS['_startUseMems'] = memory_get_usage();
        }

        error_reporting(E_ALL);

        $callback();

        $end = microtime(true);
        $use_time = ($end - $start) * 1000;
        echo "\n开发：";
        echo "\n耗时：" . $use_time . "毫秒";
        echo "\n内存：";
        echo DD_MEMORY_LIMIT_ON ? number_format((memory_get_usage() - $GLOBALS['_startUseMems']) / 1024,
                2) . ' KB' : '不支持';
        echo "\n内存峰值：" . number_format(memory_get_peak_usage() / 1024, 2) . " KB\n";
        return ;
    }

    /**
     * 使用yield存储变量支持循环处理
     * Auth: baiwei
     * DateTime: 2020/12/17
     * @param callable $callback
     */
    public static function yieldToDo(callable $callback, $y = 0)
    {
        for ($i = 0; $i < $y; $i++) {
            yield $callback();
        }
    }
}