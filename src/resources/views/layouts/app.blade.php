<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img class="img_logo" src="{{asset('storage/img/logo.svg')}}"alt="logo">
            </a>
        
            <nav class="header__nav">
                <ul class="header__nav-list">
                    @auth
                    <li class="header__nav-item">
                        <a class="header__link" href="{{ route('attendance.index') }}">勤怠</a>
                    </li>
                    <li class="header__nav-item">
                        <a class="header__link" href="{{ route('attendancelist.index') }}">勤怠一覧</a>
                    </li>
                    <li class="header__nav-item">
                        <a class="header__link" href="{{ route('request.index') }}">申請</a>
                    </li>

                    <li class="header__nav-item">
                        <a href="#" class="header__link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト
                        </a>

                            <form id="logout-form" action="/logout" method="POST" style="display:none;">
                            @csrf
                            </form>
                    </li>
                @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>


    
