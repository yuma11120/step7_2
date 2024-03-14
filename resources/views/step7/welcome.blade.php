<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        <!-- style -->
        <link href="{{ asset('css/step7welcome.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                    @else

                        @if (Route::has('register'))
                        @endif
                    @endauth
                </div>
            @endif
            <h1 class = 'title'>商品一覧画面</h1>

            <form action="{{ route('step7.welcome') }}" method="GET" class="form">
                <input type="search" name="keyword" placeholder="検索" class="input-text" />
                <input type="submit" id="search" value="検索" class="input" />
                <button type="button" onclick="window.location='{{ route('step7.welcome') }}'" class="">検索解除</button>
            </form>

            <table class = 'table'>
                
                <thead class = 'header'>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th><a href="{{ route('step7.newCreate') }}" class = 'button-create' >登録</a></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($step72s as $step72)
                        <tr>
                        <td>{{ $step72->id }}</td>
                        <td><img src="{{ asset('storage/' . $step72->picture) }}" alt="商品画像" style="width:100px;"></td>                        <td>{{ $step72->name }}</td>
                        <td>{{ $step72->price }}</td>
                        <td>{{ $step72->stock }}</td>
                        <td>{{ $step72->makerName }}</td>
                        <td ><a href="{{ route('step7.show', ['id'=>$step72->id]) }}" class = 'detail'>詳細</a></td>
                        <td>
                            <form action="{{ route('step7.destroy', ['id'=>$step72->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id">
                            <button  class = 'button-delete' type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class = "pagination">
            {{ $step72s->links('vendor.pagination.semantic-ui') }}
        </div>
    </body>
</html>
