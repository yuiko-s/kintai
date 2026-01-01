<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/attendance.css">
    <link rel="stylesheet" href="css/attendancelist.css">
    @yield('css')
</head>
<body>
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
                        <a class="header__link button--link" type="submit">ログアウト</a>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
    </header>

    <main>
        <div class="attendance-form__content">
            <div class="attendance-form__status">
                @switch($status)
                    @case(0)
                        <p>出勤中</p>
                        @break

                    @case(1)
                        <p>休憩中</p>
                        @break

                     @case(3)
                        <p>退勤済</p>
                        @break   

                    @default
                        <p>出勤外</p>
                @endswitch
            </div>    

            <div class="attendance-form__heading">
                <p>{{ $today }}</p>
            </div>

            <div class='attendance-form__time'>
                <h2>{{ $totime }}</h2>
            </div>
            
            <div class="attendance-form__button">
                @switch($status)
                    @case(0)
                    <form action="{{ route('attendances.clockout') }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="clockout_button">退勤</button>
                    </form>
                    <form action="{{ route('breaktime.breakin') }}" method="POST" style="display:inline-block; margin-left:8px;">
                        @csrf
                        <button type="submit" class="breakin_button">休憩入</button>
                    </form>
                    @break

                    @case(1)
                    <form action="{{ route('breaktime.breakout') }}" method="POST">
                        @csrf
                        <button type="submit" class="breakout_button">休憩戻</button>
                    </form>
                    @break

                    @case(3)
                        <p>お疲れさまでした。</p>
                    @break

                    @default
                    <form action="{{ route('attendances.clockin') }}" method="POST">
                        @csrf
                        <button type="submit" class="clockin_button">出勤</button>
                    </form>
                @endswitch
            </div>
        </div>
    </main>
</body>

</html>
