@extends('layouts.sidebar')

@section('content')
    <p>ユーザー検索</p>
    <div class="search_content w-100 vh-100 d-flex">
        <div class="search_users_area">
            @foreach ($users as $user)
                <div class="border one_person"
                    style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px;">
                    <div>
                        <span>ID : </span><span>{{ $user->id }}</span>
                    </div>
                    <div><span>名前 : </span>
                        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                            <span>{{ $user->over_name }}</span>
                            <span>{{ $user->under_name }}</span>
                        </a>
                    </div>
                    <div>
                        <span>カナ : </span>
                        <span>({{ $user->over_name_kana }}</span>
                        <span>{{ $user->under_name_kana }})</span>
                    </div>
                    <div>
                        @if ($user->sex == 1)
                            <span>性別 : </span><span>男</span>
                        @elseif($user->sex == 2)
                            <span>性別 : </span><span>女</span>
                        @else
                            <span>性別 : </span><span>その他</span>
                        @endif
                    </div>
                    <div>
                        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
                    </div>
                    <div>
                        @if ($user->role == 1)
                            <span>権限 : </span><span>教師(国語)</span>
                        @elseif($user->role == 2)
                            <span>権限 : </span><span>教師(数学)</span>
                        @elseif($user->role == 3)
                            <span>権限 : </span><span>講師(英語)</span>
                        @else
                            <span>権限 : </span><span>生徒</span>
                        @endif
                    </div>
                    <div>
                        @if ($user->role == 4)
                            <span>選択科目 :</span>
                            {{-- 選択科目の表示を追加 --}}
                            @foreach ($user->subjects as $subject)
                                <span>{{ $subject->subject }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="search_area w-25">
            <div class="">
                <div>
                    <h4>検索</h4>
                    <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest"
                        style="border-radius: 5px; background-color: #E0E5E9; margin: 10px 0 10px 0; height: 45px; ">
                </div>
                <div>
                    <lavel style="display: flex; margin-bottom: 10px;">カテゴリ</lavel>
                    <select form="userSearchRequest" name="category"
                        style="margin-bottom: 10px; border-radius: 5px; background-color: #E0E5E9; margin: 10px 0 10px 0; height: 35px;">
                        <option value="name">名前</option>
                        <option value="id">社員ID</option>
                    </select>
                </div>
                <div>
                    <label style="display: flex; margin-bottom: 10px;">並び替え</label>
                    <select name="updown" form="userSearchRequest"
                        style="margin-bottom: 10px; border-radius: 5px; background-color: #E0E5E9; margin: 10px 0 10px 0; height: 35px;">
                        <option value="ASC">昇順</option>
                        <option value="DESC">降順</option>
                    </select>
                </div>
                <div class="">
                    <p class="m-0 search_conditions"
                        style="border-bottom: solid 1px #000; display: flex; justify-content: space-between">
                        <span>検索条件の追加</span>
                        <span class="toggle-subcategories toggle-icon" style="cursor:pointer;">V</span>
                    </p>
                    <div class="search_conditions_inner" style="background-color: #ECF1F6;">
                        <div>
                            <label style="display: flex; margin-top: 10px;">性別</label>
                            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
                            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
                            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
                        </div>
                        <div>
                            <label style="display: flex; margin-top: 10px">権限</label>
                            <select name="role" form="userSearchRequest" class="engineer"
                                style="border-radius: 5px; background-color: #E0E5E9; height: 35px; ">
                                <option selected disabled>----</option>
                                <option value="1">教師(国語)</option>
                                <option value="2">教師(数学)</option>
                                <option value="3">教師(英語)</option>
                                <option value="4" class="">生徒</option>
                            </select>
                        </div>

                        <label style="margin-top: 10px">選択科目</label>
                        <div class="selected_engineer" style="display: flex;">

                            {{-- 選択科目の表示&検索を追加 --}}
                            @foreach ($subjects as $subject)
                                <option>{{ $subject->subject }}</option>
                                {{-- radioだと複数選択できないのでcheckboxに変更 --}}
                                <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest"
                                    style="margin-right: 10px;">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <input type="submit" name="search_btn" value="検索" form="userSearchRequest"
                        style="margin-top: 30px; border-radius: 5px; width: 100%; height: 45px; ">
                </div>
                <div>
                    <input type="submit" value="リセット" form="userSearchRequest"
                        style="border: none; margin-top: 30px; border-radius: 5px; width: 100%; height: 45px; color: #03AAD2; cursor:pointer; background-color: #ECF1F6;">
                </div>
            </div>
            <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
        </div>
    </div>
@endsection
