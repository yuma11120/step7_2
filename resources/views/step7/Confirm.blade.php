<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">



        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
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
            <h1>登録確認画面</h1>
            <h2>登録しました。</h2>
            @php
                $name = $_POST['name'];
                $price = $_POST['price'];
                $stock = $_POST['stock'];
                $makerName = $_POST['makerName'];
                $coment = $_POST['coment'];


                $dsn = 'mysql:host=localhost;dbname=step7;charset=utf8';
                $user = 'root';
                $pass = 'root';

    //接続はしている
        try{
                $dbh = new PDO($dsn, $user, $pass,[
                    PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
                ]);

                    $sql ="INSERT INTO step72 (name,makerName,stock,price,coment) VALUES (:name, :makerName, :stock, :price,:coment)";
                    $stmt = $dbh->prepare($sql);

                    $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
                    $stmt->bindValue(':makerName', $_POST['makerName'], PDO::PARAM_STR);
                    $stmt->bindValue(':stock', $_POST['stock'], PDO::PARAM_STR);
                    $stmt->bindValue(':price', $_POST['price'], PDO::PARAM_STR);
                    $stmt->bindValue(':coment', $_POST['coment'], PDO::PARAM_STR);


                    $stmt->execute();
                    header('Location: ./step7.welcome');
                    exit();
            } catch(PDOException $e){
                echo '接続失敗' . $e->getMessage();
                exit();
            }
            
            @endphp
        </div>
    </body>
</html>
