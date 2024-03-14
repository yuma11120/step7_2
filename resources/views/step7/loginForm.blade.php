<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ asset('/css/loginForm.css') }}">
    </head>
    <body>
        <div>

            <h1>ユーザーログイン画面</h1>
                <form action="login" method="post" >
                @csrf
                <div class="main">
                    <label>
                        <input type="text" name="email" placeholder = 'メールアドレス' required class = "form">
                    </label>
                </div>
                
                <div class="main">
                    <label>
                        <input type="password" name="password" placeholder = 'パスワード' required class = "form">
                    </label>
                </div>

                <div class="main">
                    <a href="signUp" class='submit'>新規登録</a>
                    <input type="submit" value="ログイン" class='submit'> 
                    <p>acosh</p>
                </div>
                
                </form>
                
            
        </div>
    </body>
</html>
