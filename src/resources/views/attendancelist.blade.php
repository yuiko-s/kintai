<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠一覧</title>
    
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
    <div class="attendancelist-form__content">
        <div class="attendancelist-form__heading">
                <h2>勤怠一覧</h2>
        </div>

        <tr>
                <a>←</a>
                <td>{{$today->copy()->subMonth()->format('Y/m');}}</td>
                <td>{{$today->format('Y/m');}}</td>
                <td>{{$today->copy()->addMonth()->format('Y/m');}}</td>
                <a>→</a>

            </tr>
        <table>
            <tr>    
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            <tr>
                
                @foreach($days as $day)
                <tr> 
                    <td>{{$day ->isoFormat('MM/DD(ddd)')}}</td>
                </tr>
                @endforeach
            </tr>
        </table>

    </div>
</main>
</head>