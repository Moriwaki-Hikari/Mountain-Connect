<?php

use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');


// require_once 'vendor/autoload.php';
//
// // POSTで送られてくるトークンを取得.
// $id_token = filter_input(INPUT_POST, 'idtoken');
//
// $client = new Google_Client(['client_id' => '1089148462358-o57v7mcn0haug04l9b1vg86ekvj4ahhi.apps.googleusercontent.com']);
// $payload = $client->verifyIdToken($id_token);

// if ($payload) {
//     $userid = $payload['sub'];
//     // ユーザ登録やログイン処理など
//     // 結果を出力
//     echo $userid;
// } else {
//     // Invalid ID token
//     // 結果を出力
//     echo null;
// }
if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new MountainController();

$err = null;
if (!empty($_POST['mode'])) {
  // セッションに入力値を入れる
    $search = $_POST['title'];
    $index = $params->search($search);
    if (count($index['events']) == 0) {
        $err = "検索結果なし";
    }
} else {
    $index = $params->index();
}

$user_id = $_SESSION['login_user']['id'];

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
    crossorigin="anonymous">
    <title>Topページ</title>
  </head>
  <body>
    <?php include(dirname(__FILE__) . '/header.php');?>
    <h1 class="text-center">イベント一覧</h1>
    <table id ="list">
      <h2 class="text-center">
        <?php if (!empty($err)) {
            echo $err;
        };?>
      </h2>
      <?php foreach ($index['events'] as $column) :?>
        <div class="mx-auto pb-3">
          <div class="text-center">
            <div class="card">

              <div class="card-header"><?php
                $name = htmlspecialchars($column['name'], ENT_QUOTES);
                ?><a href="../users/user_detail.php?id=<?php echo $column['user_id'] ?>"><?php echo $name?></a>
              </div>
              <div class="card-body"><?php
                $title = htmlspecialchars($column['title'], ENT_QUOTES);
                echo $title?>
              </div>
                <div class="card-body"><?php
                $body = htmlspecialchars($column['body'], ENT_QUOTES);
                echo $body?></div>
              <div class="card-footer">
                <div>
                  <a href="message.php?id=<?php echo $column['id'] ?>">詳細</a>
                </div>
                <div>
                  <?php $event_id = $column['id'];?>
                  <?php $dbPostGoodNum = $params->dbPostGoodNum($event_id);?>
                  <?php $dbPostGoodUser = $params->dbPostGoodUser($event_id, $user_id);?>
                  <section class="event" data-eventid="<?php echo $column['id']; ?>">
                    <div class="btn-good <?php echo ($dbPostGoodUser['dbPostGoodUser'] == 1) ? 'active':''; ?>">
                      <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
                      <i class="fa-leaf
                      <?php if ($dbPostGoodUser['dbPostGoodUser'] == 1) {
                            echo 'active fas fa-lg';
                      } else { //いいねを取り消したらハートのスタイルが取り消される
                            echo 'fa';
                      };
                        ?>">
                      </i>
                      <span><?php echo $dbPostGoodNum['dbPostGoodNum']; ?></span>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ;?>
    </table>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="/js/good.js"></script>



    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    -->
  </body>
</html>
