<?php
use Mountain\MountainController;

$_SESSION['login_user'] = [];
session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');


if (!empty($_POST) && empty($_SESSION['data'])) {
    $err = [];
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err['email'] = 'メールアドレスは正しくご入力ください。';
    }

    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err['password'] = 'パスワードは正しくご入力ください。';
    }


    if (count($err) > 0) {
      // ユーザー登録処理
        $_SESSION = $err;
        header('Location:./login.php');
        return;
    }

    $login = new MountainController();
    $result = $login->login($email, $password);
    if ($result) {
        header('Location:events/index.php');
        return;
    }
} elseif (!empty($_SESSION['data'])) {
    $_POST = $_SESSION['data'];
}

$err = $_SESSION;
$_SESSION['login_user'] = [];

session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id"
  content="1089148462358-o57v7mcn0haug04l9b1vg86ekvj4ahhi.apps.googleusercontent.com">
  <title>ログイン</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
  crossorigin="anonymous">
</head>
<body>
  <div class="container py-4" id="contact">
    <h2 class="text-center">ログインフォーム</h2>
    <p><?php echo isset($err['msg']) ? $err['msg'] : ''; ?></p>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <p><?php echo isset($err['email']) ? $err['email'] : ''; ?></p>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
        aria-describedby="emailHelp">
      </div>
      <div class="form-group mb-3">
        <label for="password">Password</label>
        <p><?php echo isset($err['password']) ? $err['password'] : ''; ?></p>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
    <button type="submit" class="btn btn-success mb-3">ログイン</button>
   </form>
   <div class="text-right">
     <div class="g-signin2" data-onsuccess="onSignIn"　data-theme="dark"></div>
   </div>

  </div>

  <script>
      // function onSignIn(googleUser)
      // {
      //     var profile = googleUser.getBasicProfile();
      //     console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      //     console.log('Name: ' + profile.getName());
      //     console.log('Image URL: ' + profile.getImageUrl());
      //     console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
      //
      //     // トークンの取得（サーバーにはこちらを送信）
      //     var id_token = googleUser.getAuthResponse().id_token;
      //     console.log('token: ' + token);
      //
    function onSignIn(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../google_login.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          console.log('Signed in as: ' + xhr.responseText);
        };
        xhr.send('id_token=' + id_token);
        window.location.href = 'events/index.php';
         //window.location.href = 'google_login.php';
    }
  </script>
  <div class="form-group row justify-content-center">
      <div class="text-center">
          <a href="register.php" class="btn btn-success">新規登録</a>
          <a href="reset.php" class="btn btn-success">パスワードリセット</a>
      </div>
  </div>

  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
