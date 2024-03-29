<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;
//バリデーション用に追加
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $posts = Post::with('user', 'postComments')->get();
        // $categories = MainCategory::get();
        //下記に変更サブカテゴリーも一緒に
        $categories = MainCategory::with('subCategories')->get();
        // dd($categories);
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('subCategories', function ($query) use ($request) {
                    $query->where('sub_category', 'like', '%' . $request->keyword . '%');
                })->get();
        } else if ($request->category_word) {
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        } else if ($request->categories_posts) {
            //サブカテゴリーでの検索
            $sub_category = $request->categories_posts;
            // dd($sub_category);
            $posts = Post::with('user', 'postComments')
                ->whereHas('subCategories', function ($q) use ($sub_category) {
                    //whereHasメソッドは関連するモデルに基づいてフィルタリングに便利（※親モデルが子モデルとの関係を持っているレコードのみを取得する場合）
                    //⇒postモデル(親)とsubcategory(子)の関連に何か条件を適用して、親モデルのレコードを取得するために使う
                    //useで使いたいキーワード($sub_category)をクロージャ内にインポート
                    //⇒これでクロージャの中で外部の変数にアクセスできる

                    $q->where('sub_categories.sub_category', $sub_category);
                    //第一引数は操作しているモデル
                    //第二引数はクロージャ関数
                    //⇒$qはクエリビルダーのインスタンス（$sub_category変数と一致する条件をフィルタリング）
                })
                ->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::get();
        //サブカテゴリーも追加
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
    }

    //新規作成
    public function postCreate(PostFormRequest $request)
    {
        // dd($request->all());
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $post->subCategories()->attach($request->sub_category_id);
        // dd($request->all());
        return redirect()->route('post.show');
    }

    //更新
    public function postEdit(Request $request)
    {
        // dd($request);
        // postバリデーション
        $request->validate([
            'post_title' => 'required|string|min:1|max:100',
            'post_body' => 'required|string|min:1|max:5000',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //投稿の削除
    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //メインカテゴリーの作成
    public function mainCategoryCreate(Request $request)
    {
        $validated = $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ]);

        // MainCategory::create(['main_category' => $request->main_category_name]);
        MainCategory::create(['main_category' => $validated['main_category_name']]);
        return redirect()->route('post.input');
    }

    //サブカテゴリーの作成
    public function subCategoryCreate(Request $request)
    {
        $validated = $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sub_categories', 'sub_category')->where(function ($query) use ($request) {
                    return $query->where('main_category_id', $request->main_category_id);
                }),
            ],
        ]);

        // SubCategory::create([
        //     'main_category_id' => $request->main_category_id,
        //     'sub_category' => $request->sub_category_name
        // ]);
        SubCategory::create([
            'main_category_id' => $validated['main_category_id'],
            'sub_category' => $validated['sub_category_name']
        ]);
        return redirect()->route('post.input');
    }

    //コメント
    public function commentCreate(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'comment' => 'required|string|max:2500',
        ]);

        PostComment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
