<?php
/**
 * 时间类
 */

namespace Gop\Tools;

class DateHp
{
    public function __construct()
    {

    }

    /**
     * 获取时间区间内的每一天的时间，把时间切割为每一天
     * Auth: baiwei
     * DateTime: 2020/12/22
     * @param $startdate
     * @param $enddate
     * @return array
     */
    public static function getDateFromRange($startdate, $enddate)
    {
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = (strtotime(date('Y-m-d 00:00:00', $etimestamp)) - strtotime(date('Y-m-d 00:00:00',
                    $stimestamp))) / 86400 + 1;
        // 保存每天日期
        $date = array();
        for ($i = 0; $i < $days; $i++) {
            if ($i == 0) {
                $date[] = [
                    'start_time' => date('Y-m-d H:i:s', $stimestamp),
                    'end_time' => date('Y-m-d 23:59:59', $stimestamp + (86400 * $i))
                ];
            } elseif ($i + 1 == $days) {
                $date[] = [
                    'start_time' => date('Y-m-d 00:00:00', $stimestamp + (86400 * $i)),
                    'end_time' => date('Y-m-d H:i:s', $etimestamp)
                ];
            } else {
                $date[] = [
                    'start_time' => date('Y-m-d 00:00:00', $stimestamp + (86400 * $i)),
                    'end_time' => date('Y-m-d 23:59:59', $stimestamp + (86400 * $i))
                ];
            }

        }
        return $date;
    }

    /**
     * 时间区间的二分法
     * Auth: baiwei
     * DateTime: 2020/12/22
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public static function cutDate($startDate, $endDate)
    {
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);
        $timeLine = ($endTime - $startTime) / 2;

        $conditionsOne['start_time'] = $startDate;
        $conditionsOne['end_time'] = date('Y-m-d H:i:s', (int)($startTime + $timeLine));


        $conditions['start_time'] = $conditionsOne['end_time'];
        $conditions['end_time'] = $endDate;
        $date = [$conditionsOne, $conditions];

        return $date;
    }

    /**
     * 获取周信息
     * @param $time
     * @return string|null
     */
    public static function getWeek($time = null)
    {
        $weeks = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
        return $weeks[date('w', $time)] ?? null;
    }
}