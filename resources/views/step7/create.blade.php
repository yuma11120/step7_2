<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">



        <link href="{{ asset('css/step7welcome.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="create">

            <h1>登録画面</h1>
            
            <!-- 一旦送信先は、/step7/Confirmに指定-->
            <form action="{{ route('step7.new') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="table">
                    <p>商品名<span>*</span></p>
                    <input type="text" name="name">
                    <p>
                </div>
                <div class="table">
                    <p>メーカー名<span>*</span></p>
                    <input type="text" name="makerName">
                    <p>
                </div>
                <div class="table">
                    <p>在庫数<span>*</span></p>
                    <input type="text" name="stock">
                    <p>
                </div>
                <div class="table">
                    <p>価格<span>*</span></p>
                    <input type="text" name="price">
                    <p>
                </div>
                <div class="table">
                    <p>コメント</p>
                    <textarea name="coment"></textarea>
                    <p>
                </div>

                <div>
                    <input type="file" name="image">
                </div>

                <div>
                    <input type="submit" value="新規作成">
                </div>
            </form>

    
                <div>
                    <a href="/step7_2/public/step7.welcome">戻る</a>
                </div>



                @if ($message = Session::get('success'))
                    <div>
                        <strong>{{ $message }}</strong>
                    </div>
                    <img src="/images/{{ Session::get('image') }}">
                @endif
        </div>
    </body>
</html>
