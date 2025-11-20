<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠登録画面</title>
    
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" herf="/">
                <img class="img_logo" src="{{asset('storage/img/logo.svg')}}"alt="logo">
            </a>
        </div>
        <nav class="header__nav">
            @auth
            @if (Auth::check())
            <li class="header__nav-item">
                    <form class="header__form" action="/logout" method="post">
                        @csrf
                        <button button class="header__link button--link" type="submit">ログアウト</button>
                    </form>
                </li>
            @endif
            @endauth
</nav>
    </header>

    <main>
        <div class="finish-form__content">
            <div class="finish-form__heading">
                <p>退勤済</p>
            </div>    

            <div class="finish-form__heading">
                <p>{{ $today }}</p>
            </div>

            <div class='finish-form__time'>
                <h2>{{ $totime }}</h2>
            </div>
            
            <div class="finish-form__comment">
                 <p>お疲れさまでした。</p>
            </div>
        </div>
    </main>
</body>

</html>
