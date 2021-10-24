<?php

use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');

if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$data = substr($_SERVER['QUERY_STRING'], 3);
$event_id = (int)$data;
$params = new MountainController();
$event = $params->getEvent();

if (!empty($_POST) && empty($_SESSION['data'])) {
    $err = [];
    if (empty($_POST['body'])) {
        $err['body'] = '本文を入力してください。';
    }
    if (empty($err)) {
      // ユーザー登録処理
        $_SESSION['data'] = $_POST;
        $data = $_SESSION['data'];
        $params->messageCreate($data);
        unset($_SESSION['data']);
        unset($_POST['body']);
        // header('Location:../events/index.php');
    }
} elseif (!empty($_SESSION['data'])) {
    $_POST = $_SESSION['data'];
    unset($_SESSION['data']);
}
// var_dump($_SESSION['login_user']['id']);
// die;
// $id = $_SESSION['login_user']['id'];
$messages = $params->getMessages($event_id);
foreach ($messages as $message) {
}
?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
    crossorigin="anonymous">
    <title>MyEvnt</title>
  </head>
  <body>
    <?php include(dirname(__FILE__) . '/header.php');?>
    <h1 class="text-center"><?php
    $title = htmlspecialchars($event['getEvent']['title'], ENT_QUOTES);
    echo $title?></h1>
    <table id ="list">
      <div class="mx-auto">
        <div class="text-center">
          <div class="card">
            <div class="card-footer"> <?php
            $body = htmlspecialchars($event['getEvent']['body'], ENT_QUOTES);
            echo $body?>
            </div>
          </div>
        </div>
      </div>
    </table>
    <h1 class="text-center">掲示板</h1>
    <div class="container py-4" id="contact">

    <form action="../events/message.php?id=<?php echo $event_id ?>" method="POST">
      <div class="form-group">
        <label for ="body">body:<?php echo isset($err['body']) ? $err['body'] : ''; ?></label>
        <textarea name="body" class="form-control" value="<?php echo isset($_POST['body']) ? htmlspecialchars($_POST['body'], ENT_QUOTES) : ''; ?>"></textarea>
      </div>
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user']['id'];?>">
      <input type="hidden" name="event_id" value="<?php echo $event_id;?>">
      <div class="text-center pb-3">
        <input type="submit" class="btn btn-success " value="投稿">
      </div>
    </form>
    <table id ="list">
      <?php
        foreach ($message as $column) :?>
        <div class="mx-auto pb-3">
          <div class="text-center">
            <div class="card">

              <div class="card-header">
                  <?php $name = htmlspecialchars($column['name'], ENT_QUOTES);?>
                  <a href="../users/user_detail.php?id=<?php echo $column['user_id'] ?>"><?php echo $name?></a>
              </div>
              <div class="card-body"><?php
                  $body = htmlspecialchars($column['body'], ENT_QUOTES);
                  echo $body?>
              </div>
                  <?php if ($_SESSION['login_user']['id'] == $column['user_id'] || ($_SESSION['login_user']['role'] == 1)) : ?>
              <div class="card-footer">
                <a class="delete" href="message_delete.php?id=<?php echo $column['id'] ?>">削除</a>
              </div>
                  <?php endif ?>
            </div>
          </div>
        </div>
        <?php endforeach ?>
    </table>

    <div class="text-center">
      <a href="../events/index.php" class="btn btn-success">戻る</a>
    </div>
    <?php if ($_SESSION['login_user']['role'] == 1) :?>
    <div class="text-right">
      <div class="delete">
        <a class="btn btn-success" href="../events/delete.php?id=<?php echo $event['getEvent']['id'] ?>">イベント削除</a>
      </div>
    </div>
    <?php endif ?>






    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="/js/style.js"></script>


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    -->
  </body>
</html>
