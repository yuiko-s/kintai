<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細画面</title>
    
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
<p>詳細画面</p>

@if ($approval && $approval->status === 'pending')

<div class="form__group">
    {{-- 日付 --}}
    <div class="form__group-title">
        <span class="form__label--item">日付</span>
    </div>
    <div class="form__group-content">
        <p>{{ $attendance?->start_time?->format('Y年m月d日') ?? '-' }}</p>
    </div>

    {{-- 出勤・退勤 --}}
    <div class="form__group-title">
        <span class="form__label--item">出勤・退勤</span>
    </div>
    <div class="form__group-content">
        <p>
            {{ $attendance?->start_time?->format('H:i') ?? '-' }}
            〜
            {{ $attendance?->end_time?->format('H:i') ?? '-' }}
        </p>
    </div>

    {{-- 休憩 --}}
    <div class="form__group-title">
        <span class="form__label--item">休憩</span>
    </div>

    @foreach($breakTimes as $breakTime)
    @if ($breakTime->break_start && $breakTime->break_end)
        <div class="form__group-content">
            <p>
                {{ $breakTime->break_start->format('H:i') }}
                〜
                {{ $breakTime->break_end->format('H:i') }}
            </p>
        </div>
    @endif
@endforeach

    {{-- 備考 --}}
    <div class="form__group-title">
        <span class="form__label--item">備考</span>
    </div>
    <div class="form__group-content">
        <p>{{ $approval->remarks ?? '―' }}</p>
    </div>
    <div class="form__group-contentlast">
        <p>・承認待ちのため修正はできません。</p>
    </div>
</div>

@else
<form action="{{ route('attendancedetail.update', ['id' => $attendance->id]) }}" method="POST">
    @csrf
    {{-- 日付 --}}
    <input type="hidden" name="id" value="{{ $attendance->id }}">                
         <div class="form__group">
            <div class="form__group-title">
                        <span class="form__label--item">日付</span>
            </div>
            <div class="form__group-content">
                <div class="text">
                    <p>{{ $attendance?->start_time?->format('Y年') ?? '-' }}</p>
                </div>
                <div class="text">
                    <p>{{ $attendance?->start_time?->format('m月d日') ?? '-' }}</p>
                    </div>
                {{-- 出勤・退勤 --}}
                <div class="form__group-title">
                    <span class="form__label--item">出勤・退勤</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="start_time" value="{{$attendance?->start_time?->format('H:i') ?? ''}}"/>
                    </div>
                    {{-- 休憩 --}}                    
                    <div class="form__input--text">
                        <input type="text" name="end_time" value="{{$attendance?->end_time?->format('H:i') ?? ''}}"/>
                    </div>
                    <div class="form__group-title">
                        <span class="form__label--item">休憩</span>
                    </div>
                    <div class="form__group-content">
                         @foreach($breakTimes as $breakTime)
                        <div class="form__input--text">
                            <input type="text" name="break_start[]" value="{{ $breakTime->break_start?->format('H:i') ?? '' }}">
                        </div>
                        <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="break_end[]" value="{{ $breakTime->break_end?->format('H:i') ?? '' }}">
                        </div>
                        @endforeach

                    {{-- 備考 --}}    
                    <div class="form__group-title">
                        <span class="form__label--item">備考</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="remarks" required/>
                        </div>
                    <div class="form__button">
                    <button class="form__button-submit" type="submit">修正</button>
                </div>

@endif


</main>
</body>
</html>

