<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    
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
        <div class="register-form__content">
            <div class="register-form__heading">
                <h2>会員登録</h2>
            </div>
            
            <form class="form" action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">名前</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name"/>
                             @error('name')
                                    {{ $message }}
                             @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">   
                        <span class="form__label--item">メールアドレス</span>              
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="email" name="email"/>
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">   
                        <span class="form__label--item">パスワード</span>              
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="password" name="password"/>
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">   
                        <span class="form__label--item">パスワード確認</span>              
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="password" name="password_confirmation"/>
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="is_admin" value="0">
                 <div class="form__button">
                    <button class="form__button-submit" type="submit">登録</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>