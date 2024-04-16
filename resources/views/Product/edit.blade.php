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

                        <form action="{{ route('Product.update', ['id'=>$Product->id]) }}" method = "post" class = 'form-container' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h1>商品情報編集画面</h1> 
                            <div class = 'editContent' >                              
                                <p>ID : {{ $Product->id }}</p>
                                <input type="hidden" name="company_id" value="{{ $Product->id }}">
                            </div>
                            <div class = 'editContent'>
                                <p>商品画像</p><input type="file" name="image_path">
                            </div>
                            <div class = 'editContent'>
                                <p>商品名</p>
                                <input type="text" value = '{{ $Product->product_name }}' name = 'product_name'>                      
                            </div>
                            <div class = 'editContent'>
                                <p>価格</p>
                                <input type="text" value = '{{ $Product->price }}' name = 'price'>
                            </div>
                            <div class = 'editContent'>
                                <p>在庫数</p>
                                <input type="text" value = '{{ $Product->stock }}' name = 'stock'>
                            </div>
                            <div class="editContent">
                                <p>メーカー名</p>
                                <select name="company_id" class="select">
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}"{{ $Product->company_id == $company->id ? ' selected' : '' }}>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class = 'editContent'>
                                <p>コメント</p>
                                <textarea  name="comment" >{{ $Product->comment }}</textarea>                            
                            </div>
                            <div class = 'editContent'>
                                <input type="submit" value = "編集">
                            </div>
                            <div>
                                <a href="/step7_test/public/">一覧画面に戻る</a>
                            </div>
                        </form>
            
            
        </div>
    </body>
</html>
