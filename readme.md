# 発着信履歴(for CX-01)

CX-01のsyslog機能を利用し、発着信履歴を管理する為のWebアプリケーションです。

このWebアプリケーションは利用者の責任においてご利用いただけますようお願い致します。 

# 使用方法

SQLiteを使う場合、.envのDB_CONNECTIONをsqliteにし、そのほかのDB関係のパラメタをコメントアウトします。

1. composer install
1. cp .env.example .env
1. php artisan key:generate
1. touch database\database.sqlite
1. php artisan migrate
1. php artisan db:seed

* 初期ユーザ：admin@example.com
* 初期パスワード：admin

## License

ベースとなっているフレームワークが Laravel のため、このWebアプリケーションもMITライセンスとします。

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
