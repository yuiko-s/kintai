# kintai
 一般ユーザーの勤怠登録を行い
 管理者が勤怠管理を行う
 為の勤怠管理アプリです。

 一般ユーザーは以下ができます。
 ・会員登録
 ・ログイン
 ・勤怠登録
 ・勤怠修正
 ・勤怠一覧確認
 ・申請状況の確認

 管理者は以下ができます。
 ・会員登録
 ・ログイン
 ・スタッフ一覧確認
 ・スタッフ別勤怠確認
 ・勤怠申請承認


#環境構築
git@github.com:yuiko-s/kintai.git
cd kintai
cd cp .env.example .env
docker-compose up -d
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed

#使用技術
Laravel　12.33.0
PHP 8.4.13
Blade
css
Mysql 8.0.26
nginx 1.21.1
phpmyadmin

#ER図
勤怠アプリ.drawio.png
https://github.com/yuiko-s/kintai/blob/ab1eed00dc27909724ebc62b9c7c870595795ec3/%E5%8B%A4%E6%80%A0%E3%82%A2%E3%83%97%E3%83%AA.drawio.png

#URL
http://localhost/login