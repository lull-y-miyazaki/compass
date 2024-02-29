@extends('layouts.sidebar')

@section('content')
    <div class="board_area w-100 border m-auto d-flex">
        <div class="post_view w-75 mt-5" style="margin-left: 5%">
            <p class="w-75 m-auto">投稿一覧</p>
            @foreach ($posts as $post)
                <div class="post_area border w-75 m-auto p-3">
                    <p><span style="color: #7d7d7d; font-weight: bold;">{{ $post->user->over_name }}</span><span
                            class="ml-3" style="color: #7d7d7d; font-weight: bold;">{{ $post->user->under_name }}さん</span>
                    </p>
                    <p><a href="{{ route('post.detail', ['id' => $post->id]) }}"
                            style="text-decoration: none; color: black; font-weight: bold;">{{ $post->post_title }}</a></p>

                    <div class="post_bottom_area d-flex">
                        {{-- サブカテゴリー表示 --}}
                        @foreach ($post->subCategories as $subCategory)
                            <span class="category_btn">{{ $subCategory->sub_category }}</span>
                        @endforeach
                        <div class="d-flex post_status">
                            <div class="mr-5">
                                {{-- コメント数追加 --}}
                                <i class="fa fa-comment"></i><span class="">{{ $post->commentCount() }}</span>
                            </div>
                            <div>
                                @if (Auth::user()->is_Like($post->id))
                                    <p class="m-0"><i class="fas fa-heart un_like_btn"
                                            post_id="{{ $post->id }}"></i><span
                                            class="like_counts{{ $post->id }}">{{-- いいね数追加 --}}{{ $post->likeCount() }}</span>
                                    </p>
                                @else
                                    <p class="m-0"><i class="fas fa-heart like_btn"
                                            post_id="{{ $post->id }}"></i><span
                                            class="like_counts{{ $post->id }}">{{-- いいね数追加 --}}{{ $post->likeCount() }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="other_area border w-25" style="margin-top: 3rem;">
            <div class="border m-4">
                <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>
                <div class="search_area">
                    <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
                    <input type="submit" value="検索" form="postSearchRequest">
                </div>
                <input type="submit" name="like_posts" class="category_btn_like" value="いいねした投稿" form="postSearchRequest;"
                    style="cursor:pointer;">
                <input type="submit" name="my_posts" class="category_btn_my" value="自分の投稿" form="postSearchRequest"
                    style="cursor:pointer;">

                {{-- サブカテゴリーでの検索 --}}
                <div class="category_search">
                    <p style="margin-top:30px;">カテゴリー検索</p>
                    <ul class="main_categories search_conditions">
                        @foreach ($categories as $category)
                            <li category_id="{{ $category->id }}"
                                style="border-bottom: solid 1px #000; width: 80%; margin-bottom: 10px; justify-content: space-between; display:flex;">
                                <span>{{ $category->main_category }}</span>
                                <span class="toggle-subcategories toggle-icon" style="cursor:pointer;">V</span>
                            </li>
                            <div class="search_post_inner" style="display:none; background-color: #ECF1F6;">
                                <ul style="width: 80%; margin-bottom: 10px;">
                                    @foreach ($category->subCategories as $subCategory)
                                        <li style="border-bottom: solid 1px #000; width: 80%; margin-bottom: 10px;">
                                            <input type="submit" name="categories_posts"
                                                value="{{ $subCategory->sub_category }}" form="postSearchRequest"
                                                style="background: initial; border: initial; padding: 0 0 0 10px;">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </ul>
                </div>


            </div>
        </div>
        <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    </div>
@endsection
