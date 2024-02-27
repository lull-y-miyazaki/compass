<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;

//Carbon は日付と時間を扱うためのPHPライブラリで、ここでは特定の週の日付を表すために使用している
//カレンダーの週と週に含まれる日々（実際の日付と空白の日付の両方）を処理するためにある？

class CalendarWeek
{
    protected $carbon;
    protected $index = 0;

    function __construct($date, $index = 0)
    {
        $this->carbon = new Carbon($date);
        $this->index = $index;
    }

    function getClassName()
    {
        return "week-" . $this->index;
    }

    function getDays()
    {
        $days = [];
        $startDay = $this->carbon->copy()->startOfWeek();
        $lastDay = $this->carbon->copy()->endOfWeek();
        $tmpDay = $startDay->copy();

        while ($tmpDay->lte($lastDay)) {
            if ($tmpDay->month != $this->carbon->month) {
                $day = new CalendarWeekBlankDay($tmpDay->copy());
                $days[] = $day;
                $tmpDay->addDay(1);
                continue;
            }
            $day = new CalendarWeekDay($tmpDay->copy());
            $days[] = $day;
            $tmpDay->addDay(1);
        }
        return $days;
    }
}
