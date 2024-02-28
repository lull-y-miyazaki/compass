<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    //予約機能
    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // dd(count($getDate), count($getPart));
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach ($reserveDays as $key => $value) {
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users'); //-1
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    //キャンセル機能
    public function delete(Request $request)
    {
        dd($request);

        //受け取ったデータを変数に代入
        $setting_reserve = $request->input('reserve_date');
        // dd($setting_reserve);
        $setting_part = $request->input('reserve_part');
        // dd($setting_part);
        // dd($setting_reserve);
        // dd($setting_part);

        $setting_reserve = ReserveSettings::where('setting_reserve', $setting_reserve)->where('setting_part', $setting_part)->first();
        //ReserveSettingsモデルを使用して、データベース内の値に一致するレコードを検索
        //setting_reserveカラムが$setting_reserve変数の値
        //setting_partカラムが$setting_part変数の値

        $setting_reserve->increment('limit_users');
        //検索で見つかったレコードのlimit_usersフィールドの値を1増やす

        $setting_reserve->users()->detach(Auth::id());
        //$setting_reserve オブジェクトに紐づいている users リレーションから、現在認証されているユーザー（Auth::id() で取得）を削除。detach メソッドは、多対多リレーションで関連付けられているレコードを解除

        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);

        // $request->all();
        // $reserveSetting_date = $request->input('reserve_date');
        // $reserveSetting_part = $request->input('reserve_part');
        // // dd($reserveSetting_date);
        // // dd($reserveSetting_part);

        // $reserveSetting = ReserveSettings::where('setting_reserve', $reserveSetting_date)->where('setting_part', $reserveSetting_part)->first();

        // if ($reserveSetting) {
        //     $reserveSetting->increment('limit_users');
        //     $reserveSetting->users()->detach(Auth::id());
        // }
    }
}
