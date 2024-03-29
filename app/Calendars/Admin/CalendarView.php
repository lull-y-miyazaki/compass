<?php

namespace App\Calendars\Admin;

//このCarbonは、nesbot/carbon パッケージの src/Carbon ディレクトリ内にある Carbon.phpに
//Carbonライブラリの主要な機能を含み、日付と時刻に関する操作を行うためのメソッドが定義されている
use Carbon\Carbon;
use App\Models\Users\User;

//たぶん予約確認画面

class CalendarView
{
    private $carbon;

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    public function getTitle()
    {
        return $this->carbon->format('Y年n月');
    }

    public function render()
    {
        $html = [];
        $html[] = '<div class="calendar text-center">';
        $html[] = '<table class="table m-auto border">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th class="border">月</th>';
        $html[] = '<th class="border">火</th>';
        $html[] = '<th class="border">水</th>';
        $html[] = '<th class="border">木</th>';
        $html[] = '<th class="border">金</th>';
        $html[] = '<th class="day-sat border">土</th>';
        $html[] = '<th class="day-sun border">日</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';

        $weeks = $this->getWeeks();

        foreach ($weeks as $week) {
            $html[] = '<tr class="' . $week->getClassName() . '">';
            $days = $week->getDays();
            foreach ($days as $day) {
                $startDay = $this->carbon->format("Y-m-01");
                $toDay = $this->carbon->format("Y-m-d");
                if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                    $html[] = '<td class="past-day border ' . $day->getClassName() . '">';
                    //$day->getClassName()が無いと土日カラー反映されない
                } else {
                    $html[] = '<td class="border ' . $day->getClassName() . '">';
                }
                //スクール予約確認のカレンダー部分
                $html[] = $day->render(); //日付
                $html[] = $day->dayPartCounts($day->everyDay());
                //(部数)Admin/CalendarWeekdayにあるメソッド

                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }
        $html[] = '</tbody>';
        $html[] = '</table>';
        $html[] = '</div>';

        return implode("", $html);
    }

    protected function getWeeks()
    {
        $weeks = [];
        $firstDay = $this->carbon->copy()->firstOfMonth();
        $lastDay = $this->carbon->copy()->lastOfMonth();
        $week = new CalendarWeek($firstDay->copy());
        $weeks[] = $week;
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
        while ($tmpDay->lte($lastDay)) {
            $week = new CalendarWeek($tmpDay, count($weeks));
            $weeks[] = $week;
            $tmpDay->addDay(7);
        }
        return $weeks;
    }
}
