<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
//Requestにまずここを通過させて、バリデーションをかけてからcontrollerに送る

class RequestValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //生年月日をまとめるメソッドの作成
    public function getValidatorInstance()
    {
        //値を取得
        $year = $this->input('old_year');
        $month = $this->input('old_month');
        $day = $this->input('old_day');

        //結合
        $birth_day = $year . '-' . $month . '-' . $day;

        //merge メソッドを使用して、現在のリクエストインスタンスに新しいデータを追加
        //これにより、この結合された日付を後続のバリデーションプロセスで使用できる
        $this->merge([
            'birth_day' => $birth_day,
        ]);

        //getValidatorInstance メソッド
        //カスタムバリデーションから通常のバリデーションへ続行するために必要
        return parent::getValidatorInstance();
    }

    //バリデーションルール
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10|min:1',
            'under_name' => 'required|string|max:10|min:1',
            'over_name_kana' => 'required|string|max:30|min:1|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:30|min:1|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => 'required|email|max:100|min:5|unique:users',
            'sex' => 'required|in:1,2,3',
            'role' => 'required|in:1,2,3,4',
            'birth_day' => 'required|date|after:1999-12-31|before:tomorrow',
            'password' => 'required|min:8|max:30|confirmed',
        ];
    }

    //エラーメッセージ
    public function messages()
    {
        return [
            "required" => "必須項目です",
            "email" => "メールアドレスの形式で入力してください",
            "regex" => "全角カタカナで入力してください",
            "string" => "文字列で入力してください",
            "max" => "30文字以内で入力してください",
            "over_name.max" => "10文字以内で入力してください",
            "under_name.max" => "10文字以内で入力してください",
            "min" => "8文字以上で入力してください",
            "mail_address.max" => "100文字以内で入力してください",
            "unique" => "登録済みのメールアドレスを入力しないでください",
            "confirmed" => "パスワード確認が一致していません",
            "birth_day.date" => "有効な日付を入力してください"
        ];
    }
}
