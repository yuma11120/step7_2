<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->


        <link href="{{ asset('css/step7welcome.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

                        <form action="{{ route('step7.update', ['id'=>$step72->id]) }}" method = "post" class = 'form-container' enctype="multipart/form-data">
                        @csrf
                        <h1>商品情報編集画面</h1> 
                            <div class = 'editContent' >
                                <p>ID</p>
                                <p>{{ $step72->id }}</p>
                                <input type="hidden" name="id" value="{{ $step72->id }}">
                            </div>
                            <div class = 'editContent'>
                                <p>商品画像</p><input type="file" name="image">
                            </div>
                            <div class = 'editContent'>
                                <p>商品名</p>
                                <input type="text" value = '{{ $step72->name }}' name = 'name'>                      
                            </div>
                            <div class = 'editContent'>
                                <p>価格</p>
                                <input type="text" value = '{{ $step72->price }}' name = 'price'>
                            </div>
                            <div class = 'editContent'>
                                <p>在庫数</p>
                                <input type="text" value = '{{ $step72->stock }}' name = 'stock'>
                            </div>
                            <div class = 'editContent'>
                                <p>メーカー名</p>
                                <input type="text" value = '{{ $step72->makerName }}' name = 'makerName'>
                            </div>
                            <div class = 'editContent'>
                                <p>コメント</p>
                                <textarea name="coment" value = "{{ $step72->coment }}"></textarea>                            
                            </div>
                            <div class = 'editContent'>
                                <input type="submit" value = "編集">
                            </div>
                            <div>
                                <a href="/step7_2/public/step7.welcome">一覧画面に戻る</a>
                            </div>
                        </form>
            
            
        </div>
    </body>
</html>
