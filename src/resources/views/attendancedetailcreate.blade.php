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


<form action="{{ route('attendancedetail.create') }}" method="POST">
    @csrf

    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">名前</span>
        </div>
        <div class="form__group-content">
            <div class="text">
                <p>{{ Auth::user()->name }}</p>
            </div>
        </div>

        <div class="form__group-title">
            <span class="form__label--item">日付</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="date" name="work_date" value="{{ old('work_date') }}">
            </div>
        </div>

        <div class="form__group-title">
            <span class="form__label--item">出勤・退勤</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="start_time" value="{{ old('start_time') }}" placeholder="09:00">
            </div>

            <div class="form__input--text">
                <input type="text" name="end_time" value="{{ old('end_time') }}" placeholder="18:00">
            </div>
        </div>

        <div class="form__group-title">
            <span class="form__label--item">休憩</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="break_start" value="{{ old('break_start') }}" placeholder="12:00">
            </div>

            <div class="form__input--text">
                <input type="text" name="break_end" value="{{ old('break_end') }}" placeholder="13:00">
            </div>
        </div>

        <div class="form__group-title">
            <span class="form__label--item">備考</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="note" value="{{ old('note') }}">
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">登録</button>
        </div>
    </div>
</form>