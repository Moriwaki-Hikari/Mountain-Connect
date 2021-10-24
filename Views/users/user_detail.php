<?php

use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');

if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new MountainController();
$index = $params->findByUser();
$id = $index['findByUser']['id'];
$diary = $params->myDiary($id);
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
    <title>プロフィール</title>
  </head>
  <body>
    <?php include(dirname(__FILE__) . '/header.php');?>
    <h1 class="text-center">プロフィール</h1>
    <table id ="list">
      <div class="mx-auto pb-3">
        <div class="text-center">
          <div class="card">
            <div class="card-header">
              <?php $name = htmlspecialchars($index['findByUser']['name'], ENT_QUOTES);
                echo $name?>
            </div>
            <div class="card-body"><?php
              $body = htmlspecialchars($index['findByUser']['body'], ENT_QUOTES);
                echo $body?>
            </div>
          </div>
        </div>
      </div>
    </table>
    <table>
      <h1 class="text-center">記事</h1>
      <?php
        foreach ($diary['myDiary'] as $column) :?>
        <div class="mx-auto pb-3">
          <div class="text-center">
            <div class="card">
              <div class="card-header"><?php
                $title = htmlspecialchars($column['title'], ENT_QUOTES);
                echo $title?>
              </div>
              <div class="card-body"><?php
                $body = htmlspecialchars($column['body'], ENT_QUOTES);
                echo $body?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
    </table>
    <?php if ($_SESSION['login_user']['role'] == 1) :?>
    <div class="text-center pb-3">
      <div class="delete"><a class="btn btn-success" href="user_delete.php?id=<?php echo $id ?>">削除</a></div>
    </div>
    <?php endif?>
    <div class="text-center">
      <a href="../events/index.php" class="btn btn-success">戻る</a>
    </div>





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
