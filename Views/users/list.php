<?php

use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');

if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new MountainController();
$index = $params->userList();
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
    <title>ユーザー一覧ページ</title>
  </head>
  <body>
    <?php include(dirname(__FILE__) . '/header.php');?>
    <h1 class="text-center">ユーザー一覧</h1>
    <table id ="list">
      <?php
        foreach ($index['userList'] as $column) :?>
        <div class="mx-auto pb-3">
          <div class="text-center">
            <div class="card">
              <div class="card-header"><?php
                $name = htmlspecialchars($column['name'], ENT_QUOTES);?>
                  <?php echo $name?>
              </div>
              <div class="card-body"><?php
                $body = htmlspecialchars($column['body'], ENT_QUOTES);
                echo $body?>
              </div>
              <div class="card-footer"><a href="../users/user_detail.php?id=<?php echo $column['id'] ?>">詳細</a></div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </table>


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
