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
            <table>
                <tr>
                    <th>日付</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
                @foreach ($days as $day)
                    @php
                        $dateKey = $day->format('Y-m-d');
                        $attendance = $attendances[$dateKey] ?? null;
                    @endphp
                    
                    <tr>
                        <td>{{ $day->locale('ja')->isoFormat('M/D(ddd)') }}</td>
                        <td>
                            @if ($attendance)
                               {{ $attendance->start_time->format('H:i') }}
                            @endif
                        </td>
                        <td>
                            @if ($attendance)
                               {{ $attendance->end_time->format('H:i') }}
                            @endif
                        </td>
                        <td>
                                {{ $breakMinutesByDate[$dateKey] ?? '0:00' }}
                                
                        </td>
                        <td>
                                {{ $workTimeTextByDate[$dateKey] ?? '0:00' }}
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </main>
</body>

</html>
