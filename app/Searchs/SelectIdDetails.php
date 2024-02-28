<?php

namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers
{

    // 改修課題：選択科目の検索機能
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        if (is_null($keyword)) {
            $keyword = User::get('id')->toArray();
        } else {
            $keyword = array($keyword);
        }
        if (is_null($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = array($gender);
        }
        if (is_null($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = array($role);
        }
        $users = User::with('subjects')
            ->whereIn('id', $keyword)
            ->where(function ($q) use ($role, $gender) {
                $q->whereIn('sex', $gender)
                    ->whereIn('role', $role);
            })
            ->whereHas('subjects', function ($q) use ($subjects) {
                $q->whereIn('subjects.id', $subjects);
                //$q->where('subjects.id', $subjects);
                //whereInで複数の値のいずれかと一致するレコードを検索
                //whereNotInは指定した値のいずれとも一致しないレコードを検索
                //whereHasは関連するモデルが特定の条件を満たす場合にのみ、親モデルのレコードを取得するために使用
                //orWhereは複数の条件のうち少なくとも一つが真である場合にレコードを取得する
                //whereInとorWhereの違い
                //whereIn は、指定した配列の中に値が存在するレコードを選択するために使用されます。
                //orWhereNotIn は、「OR」条件の下で、指定した配列に値が含まれないレコードを選択するために使用されます。
            })
            ->orderBy('id', $updown)->get();
        return $users;
    }
}
