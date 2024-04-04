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
            <div class="form">
                <form action="{{ route('Product.welcome') }}" method="GET">
                    <input type="search" name="keyword" placeholder="検索" class="input-text" />
                                        <!-- メーカーを選択するためのセレクトボックスを追加 -->
                    <select name="company_id" class="select">
                        <option>メーカー名を検索</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"{{ request('company_id') == $company->id ? ' selected' : '' }}>{{ $company->company_name }}</option>
                        @endforeach
                    </select>

                    <input type="submit" id="search" value="検索" class="input" />
                    <button type="button" onclick="window.location='{{ route('Product.welcome') }}'" class="">検索解除</button>
                </form>


            </div>
            <div>
                <table class = 'table'>
                    
                    <thead class = 'header'>
                        <tr>
                            <th>ID</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th><a href="{{ route('Product.newCreate') }}" class = 'button-create' >登録</a></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Products as $Product)
                            <tr>
                            <td>{{ $Product->id }}</td>
                            <td><img src="{{ asset('images/' . $Product->image_path) }}" alt="商品画像" style="width: 30px; "> <!-- 画像の幅を150pxに設定 -->
                            <td>{{ $Product->product_name }}</td>
                            <td>{{ $Product->price }}</td>
                            <td>{{ $Product->stock }}</td>
                            <td>{{ $Product->company->company_name }}</td>
                            <td ><a href="{{ route('Product.show', ['id'=>$Product->id]) }}" class = 'detail'>詳細</a></td>
                            <td>
                                <form action="{{ route('Product.destroy', ['id'=>$Product->id]) }}" method="POST">
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
        </div>
        <div class = "pagination">
            {{ $Products->links('vendor.pagination.semantic-ui') }}
        </div>
    </body>
</html>
