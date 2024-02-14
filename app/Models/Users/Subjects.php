<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Users\User', 'subject_users', 'subject_id', 'user_id');
        // 多対多のリレーションの定義
        //(第一引数'リレーションするテーブル',第二引数'中間テーブル',第三引数'リレーションを定義しているid',第四引数'結合する外部id')
    }
}
