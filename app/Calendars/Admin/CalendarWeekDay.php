<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay
{
    protected $carbon;

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    function getClassName()
    {
        return "day-" . strtolower($this->carbon->format("D"));
    }

    function render()
    {
        return '<p class="day">' . $this->carbon->format("j") . '日</p>';
    }

    function everyDay()
    {
        return $this->carbon->format("Y-m-d");
    }

    //予約確認ページの部数の表示
    //Admin/CalendarViewで使用
    function dayPartCounts($ymd)
    {
        // dd($ymd);
        $html = [];
        // それぞれのパートの予約情報を取得
        $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
        $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
        $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
        //generalの見て
        $html[] = '<div class="text-left">';
        if ($one_part) {
            // dd($one_part);
            // $html[] = '<p class="day_part m-0 pt-1">1部</p>';
            ///ルーティングがcalendar/{date}/{part}なので、
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '1']) . '" class="sett_a">1部 </a>';
            $html[] = '<a class="m-0 pt-1 sett_text">' . $one_part->users->count() . '人</a><br>';
        } else {
            // $html[] = '<a class="m-0 pt-1">1部: 0人</a><br>';
            // $html[] = '<span class="m-0 pt-1 sett_a">1部： </span>' . '<span class="sett_text">0人</span><br>';
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '1']) . '" class="sett_a">1部 </a>';
            $html[] = '<a class="m-0 pt-1">' . '<span class="sett_text">0人</span><br>';
        }
        if ($two_part) {
            // dd($two_part);
            // $html[] = '<p class="day_part m-0 pt-1">2部</p>';
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '2']) . '" class="sett_a">2部 </a>';
            $html[] = '<span class="m-0 pt-1 sett_text">' . $two_part->users->count() . '人</span><br>';
        } else {
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '2']) . '" class="sett_a">2部 </a>';
            $html[] = '<a class="m-0 pt-1">' . '<span class="sett_text">0人</span><br>';
        }
        if ($three_part) {
            // $html[] = '<p class="day_part m-0 pt-1">3部</p>';
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '3']) . '" class="sett_a">3部 </a>';
            $html[] = '<span class="m-0 pt-1 sett_text">' . $three_part->users->count() . '人</span><br>';
        } else {
            $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => '3']) . '" class="sett_a">3部 </a>';
            $html[] = '<a class="m-0 pt-1">' . '<span class="sett_text">0人</span><br>';
        }
        $html[] = '</div>';

        return implode("", $html);
    }


    function onePartFrame($day)
    {
        $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
        if ($one_part_frame) {
            $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
        } else {
            $one_part_frame = "20";
        }
        return $one_part_frame;
    }
    function twoPartFrame($day)
    {
        $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
        if ($two_part_frame) {
            $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
        } else {
            $two_part_frame = "20";
        }
        return $two_part_frame;
    }
    function threePartFrame($day)
    {
        $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
        if ($three_part_frame) {
            $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
        } else {
            $three_part_frame = "20";
        }
        return $three_part_frame;
    }

    //
    function dayNumberAdjustment()
    {
        $html = [];
        $html[] = '<div class="adjust-area">';
        $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
        $html[] = '</div>';
        return implode('', $html);
    }
}
