<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

//スクール予約ページ

class CalendarView
{
    //Carbon は日付と時間を扱うためのPHPライブラリで、ここでは特定の週の日付を表すために使用している
    private $carbon;
    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    public function getTitle()
    {
        return $this->carbon->format('Y年n月');
    }

    //スクール予約に関するメソッド
    function render()
    {
        $html = [];
        $html[] = '<div class="calendar text-center">';
        $html[] = '<table class="table border">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th class="border">月</th>';
        $html[] = '<th class="border">火</th>';
        $html[] = '<th class="border">水</th>';
        $html[] = '<th class="border">木</th>';
        $html[] = '<th class="border">金</th>';
        $html[] = '<th class=" day-sat border">土</th>';
        $html[] = '<th class=" day-sun border">日</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';
        $weeks = $this->getWeeks();

        foreach ($weeks as $week) {
            $html[] = '<tr class="' . $week->getClassName() . '">';
            $days = $week->getDays();

            foreach ($days as $day) {
                $startDay = $this->carbon->copy()->format("Y-m-01");
                $toDay = $this->carbon->copy()->format("Y-m-d");

                if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                    // $html[] = '<td class="past-day border">';
                    $html[] = '<td class="past-day border ' . $day->getClassName() . '">';
                    //過去日の背景色修正(cssでpast-dayのクラス名あり,元はcalendar-td)
                } else {
                    $html[] = '<td class="calendar-td border ' . $day->getClassName() . '">';
                }
                $html[] = $day->render();

                // その日に予約があるかどうかをチェック
                //予約してたら予約数の表示
                if (in_array($day->everyDay(), $day->authReserveDay())) {
                    $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;

                    if ($reservePart == 1) {
                        $reservePart = "リモ1部";
                    } else if ($reservePart == 2) {
                        $reservePart = "リモ2部";
                    } else if ($reservePart == 3) {
                        $reservePart = "リモ3部";
                    }

                    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                        //過去日の参加の表示(上記をコピー)
                        //過去日で予約していたら
                        $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
                        if ($reservePart == 1) {
                            //<p></p>の間が空いてた
                            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">1部参加</p>';
                            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        } else if ($reservePart == 2) {
                            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">2部参加</p>';
                            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        } else if ($reservePart == 3) {
                            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">3部参加</p>';
                            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        }
                        //キャンセルボタンエリア
                        //DBのCalendarテーブルにdeleted_atがあるし、compassにはキャンセル者表示があるから論理削除？Calendarテーブル使ってなく、ややこしかったので物理削除に
                    } else {
                        //$html[] = '<button type="submit" class="btn btn-danger p-0 w-75 js-open-modal" data-reserve_part="' . $day->authReserveDate($day->everyDay())->first()->setting_part . '" data-reserve_date="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">
                        // ' . $reservePart . '</button>';
                        // dd($reservePart);
                        //partのみだからdateを追加

                        //予約ができなくなったため変更
                        $html[] = '<div class="modal_open"  reserve_part="' . $day->authReserveDate($day->everyDay())->first()->setting_part . '" reserve_date="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">
<button type="submit" class="btn btn-danger p-0 w-75 " name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">
            ' . $reservePart . '</button></div>';

                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    }
                    //$day->authReserveDay() で返される予約日のリストに現在の日付 ($day->everyDay()) が含まれていない場合に、「受付終了」と表示
                } else if (!in_array($day->everyDay(), $day->authReserveDay()) && $startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                    $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color: #111;">受付終了</p>';
                    $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

                    //スクール予約部分？
                } else {
                    //selectPartはCalendareekDay.php(General)に
                    $html[] = $day->selectPart($day->everyDay());
                }
                $html[] = $day->getDate();
                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }
        $html[] = '</tbody>';
        $html[] = '</table>';
        $html[] = '</div>';
        $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
        $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

        return implode('', $html);
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
