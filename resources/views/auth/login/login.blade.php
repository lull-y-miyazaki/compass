<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AtlasBulletinBoard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap"
        rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body style="background: #ECF1F6;">
    <form action="{{ route('loginPost') }}" method="POST">
        <div class="w-100 vh-100 d-flex logo_image" style="align-items:center; justify-content:center;">
            <img src="{{ asset('image/atlas-black.png') }}" width="150px" style="margin:0 0 50px 0;">
            <div class="border vh-50 w-25"
                style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px;  background-color: #fefefe">
                <div class="w-75 m-auto pt-5">
                    <label class="d-block m-0" style="font-size:13px; font-weight:bold;">メールアドレス</label>
                    <div class="border-bottom border-primary w-100">
                        <input type="text" class="w-100 border-0" name="mail_address">
                    </div>
                </div>
                <div class="w-75 m-auto pt-5">
                    <label class="d-block m-0" style="font-size:13px; font-weight:bold;">パスワード</label>
                    <div class="border-bottom border-primary w-100">
                        <input type="password" class="w-100 border-0" name="password">
                    </div>
                </div>
                <div class="text-right m-3">
                    <input type="submit" class="btn btn-primary" value="ログイン">
                </div>
                <div class="text-center">
                    <a href="{{ route('registerView') }}">新規登録はこちら</a>
                </div>
            </div>
            {{ csrf_field() }}
        </div>
        @if ($errors->any())
            <!-- $errors変数 バリデーションエラーがあるかのチェック -->
            <div class="alert alert-danger">
                <!-- もしエラーがある場合、alertとalert-dangerというクラスを持つHTMLのdiv要素が作成(Bootstrapのクラス？) -->
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</body>

</html>
