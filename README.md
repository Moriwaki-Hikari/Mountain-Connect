# Mountain-Connect

PHP自作

# 概要
登山者が利用できる掲示板の様なサイト作成致しました。

管理人と一般ユーザに分け、 それぞれでログインできるようにしています。

# 機能一覧
機能
管理者
一般
ログイン
o
o
パスワードリセット
o
o
ユーザー登録
x
o
登った山の記事
x
o
登りたい山リスト(CRUD機能)
o（削除のみ）
o
いいね機能
o
o
全ユーザー閲覧
o
x



# 使い方
管理人

全イベント、全メッセージ、全ユーザーの削除が出来る様になっております。

テストアカウント：admin

メールアドレス→admin@admin

パスワード→adminadmin

一般ユーザ

イベントの作成、編集、削除  diaryの作成、編集、削除　良いね機能が出来る様になっております。

テストアカウント：Test_user

メールアドレス→test@test.com

パスワード→testtest

# 環境
MAMP/MySQL/PHP

# データベース
データベース名：mountain_connect

テーブル
users, events, likes, messages, diaries

お使いのphpMyAdminに上のデータベースを作り、入っているDB.sqlをインポートしていただければお使いいただけるようになると思います。
