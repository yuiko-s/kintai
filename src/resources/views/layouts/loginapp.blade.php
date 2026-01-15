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
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>


    
