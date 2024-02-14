<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'over_name' => '鳥山',
                'under_name' => '明',
                'over_name_kana' => 'トリヤマ',
                'under_name_kana' => 'アキラ',
                'mail_address' => 'toriyama@lull.com',
                'sex' => 1, // 男性
                'birth_day' => '1995-04-05',
                'role' => '1',
                'password' => Hash::make('12345'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'over_name' => '尾田',
                'under_name' => '栄一郎',
                'over_name_kana' => 'オダ',
                'under_name_kana' => 'エイイチロウ',
                'mail_address' => 'oda@lull.com',
                'sex' => 1, // 男性
                'birth_day' => '1975-01-01',
                'role' => '1',
                'password' => Hash::make('12345'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'over_name' => '岸本',
                'under_name' => '斉史',
                'over_name_kana' => 'キシモト',
                'under_name_kana' => 'マサシ',
                'mail_address' => 'kisimoto@lull.com',
                'sex' => 2, // 女性
                'birth_day' => '1974-11-08',
                'role' => '1',
                'password' => Hash::make('12345'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'over_name' => '井上',
                'under_name' => '雄彦',
                'over_name_kana' => 'イノウエ',
                'under_name_kana' => 'タケヒコ',
                'mail_address' => 'inoue@lull.com',
                'sex' => 1, // 男性
                'birth_day' => '1967-01-12',
                'role' => '3',
                'password' => Hash::make('12345'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'over_name' => '冨樫',
                'under_name' => '義博',
                'over_name_kana' => 'トガシ',
                'under_name_kana' => 'ヨシヒロ',
                'mail_address' => 'togasi@lull.com',
                'sex' => 2, // 女性
                'birth_day' => '1966-04-27',
                'role' => '2',
                'password' => Hash::make('12345'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
