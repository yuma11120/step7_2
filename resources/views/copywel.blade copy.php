<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- style -->
        <link rel="stylesheet" href="{{ 'step7.welcome.css' }}">

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            @php
                //データベース接続
                $dsn='mysql:dbname=step7;host=localhost;charset=utf8';
                $user='root';
                $password='root';

                $dbh=new PDO($dsn,$user,$password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                //下の検索のためのクラス名等諸々の変更をする必要あり

                //「検索」ボタン押下時
                if (isset($_POST["search"])) {

                    //「名前」だけ入力されている場合
                    if (isset($_POST["search_name"]) && empty($_POST["search_makerName"])){
                        $search_name = $_POST["search_name"];
                        $search_makerName = '';
                    }

                    //「メーカー名」だけ入力されている場合
                    if (empty($_POST["search_name"]) && isset($_POST["search_makerName"])){
                        $search_name = '';
                        $search_makerName = $_POST["search_makerName"];
                    }

                    //「名前」「メーカー名」両方が入力されている場合
                    if (isset($_POST["search_name"]) && isset($_POST["search_makerName"])){
                        $search_name = $_POST["search_name"];
                        $search_makerName = $_POST["search_makerName"];
                    }

                    //実行
                    $sql="SELECT * FROM step72 WHERE name like '%{$search_name}%' and makerName like '%{$search_makerName}%'";
                    $step72 = $dbh->prepare($sql);
                    $step72->execute();
                    $step72s = $step72->fetchAll(PDO::FETCH_ASSOC);

                }else{

                        //「検索」ボタン押下してないとき
                        $sql='SELECT * FROM step72 WHERE 1';
                        $step72 = $dbh->prepare($sql);
                        $step72->execute();
                        $step72s = $step72->fetchAll(PDO::FETCH_ASSOC);
                    }

                //データベース切断
                $dbh=null;
            @endphp
            
            <!--検索-->
                <form action="step7.welcome" method="POST">
                <table style="border-collapse: collapse">
                <tr>
                <th>商品名</th>
                <td><input type="text" name="search_name" value="<?php if( !empty($_POST['search_name']) ){ echo $_POST['search_name']; } ?>"></td></td>
                <th>メーカー名</th>
                <td><input type="text" name="search_makerName" value="<?php if( !empty($_POST['search_makerName']) ){ echo $_POST['search_makerName']; } ?>"></td>
                <td><input type="submit" name="search" value="検索"></td>
                </tr>
                </table>

            <table>
                
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($step72s as $step72)
                        <tr>
                        <td><?php echo $step72['id'];?></td>
                        <td><?php echo $step72['picture'];?></td>
                        <td><?php echo $step72['name'];?></td>
                        <td><?php echo $step72['price'];?></td>
                        <td><?php echo $step72['stock'];?></td>
                        <td><?php echo $step72['makerName'];?></td>
                            @csrf
                            <input type="hidden" name="id">
                            <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <a href="{{ route('step7.newCreate') }}">登録</a>
            </div>
        </div>
        <div class = 'pagination'>
        links(('pagination::default'))  
        </div>
    </body>
</html>
