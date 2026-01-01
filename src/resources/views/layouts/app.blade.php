<!DOCTYPE html>
< lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/attendance.css">
    <link rel="stylesheet" href="css/attendancelist.css">
    @yield('css')
</head>
<>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img class="img_logo" src="{{asset('storage/img/logo.svg')}}"alt="logo">
            </a>
        </div>
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
                    <form class="header__form" action="/logout" method="post">
                        @csrf
                        <button button class="header__link button--link" type="submit">ログアウト</button>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
    </header>


    
