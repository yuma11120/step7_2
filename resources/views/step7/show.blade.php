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
        <div class="confirm-container">

            <h1>商品情報詳細画面</h1>        
                    <table class = ''>
                        <tr>
                            <th>ID</th>
                            <th>{{ $step72s->id }}</th>
                        </tr>
                        <tr>
                            <th>商品画像</th>
                            <th>{{ $step72s->picture }}</th>
                        </tr>
                        <tr>
                            <th>商品名</th>
                            <th>{{ $step72s->name }}</th>
                        </tr>
                        <tr>
                            <th>価格</th>
                            <th>{{ $step72s->price }}</th>
                        </tr>
                        <tr>
                            <th>在庫数</th>
                            <th>{{ $step72s->stock }}</th>
                        </tr>
                        <tr>
                            <th>メーカー名</th>
                            <th>{{ $step72s->makerName }}</th>
                        </tr>
                        <tr>
                            <th>コメント</th>
                            <th>{{ $step72s->coment }}</th>
                        </tr>
                    </table>
                    <a href="{{ route('step7.edit', ['id'=>$step72s->id]) }}">編集</a>
        
        <div>
            <a href="/step7_2/public/step7.welcome">一覧画面に戻る</a>
        </div>
            
        </div>


    </body>
</html>
