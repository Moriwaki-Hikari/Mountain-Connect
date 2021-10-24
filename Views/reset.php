<?php
use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');
// $params = new MountainController();
// $result = $params->checkLogin();
// if ($result) {
//     header('Location: index.php');
//     return;
// }
if (!empty($_POST) && empty($_SESSION['data'])) {
    $err = [];
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err['email'] = 'メールアドレスは正しくご入力ください。';
    }

    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err['password'] = 'パスワードは正しくご入力ください。';
    }

    if (empty($_POST['password']) || !preg_match("/\A[a-z\d]{8,100}+\z/i", $_POST['password'])) {
        $err['password'] = 'パスワードは英数字８文字以上100文字以下にしてください。';
    }

    if ($_POST['password'] !== $_POST['password_conf']) {
        $err['password_conf'] = '確認用パスワードと異なっています。';
    }



    if (count($err) > 0) {
      // ユーザー登録処理
        $_SESSION = $err;
        header('Location:./reset.php');
        return;
    }
    $params = new MountainController();
    $result = $params->reset($email, $password);
    if ($result) {
        header('Location: login.php');
        return;
    }
} elseif (!empty($_SESSION['data'])) {
    $_POST = $_SESSION['data'];
}


$err = $_SESSION;

session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>パスワードリセット</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
  crossorigin="anonymous">
</head>
<body>
  <div class="container py-4" id="contact">
    <h2 class="text-center">パスワードリセットフォーム</h2>
    <p><?php echo isset($err['msg']) ? $err['msg'] : ''; ?></p>
    <?php echo isset($login_err) ? $login_err : ''; ?>

    <form action="reset.php" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <p><?php echo isset($err['email']) ? $err['email'] : ''; ?></p>
        <input type="text" name="email" class="form-control" id="exampleInputEmail1"
        aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <p><?php echo isset($err['password']) ? $err['password'] : ''; ?></p>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label for="password_conf">Password確認</label>
        <p><?php echo isset($err['password_conf']) ? $err['password_conf'] : ''; ?></p>
        <input type="password" name="password_conf" class="form-control" id="exampleInputPassword_conf1">
      </div>
      <button type="submit" class="btn btn-success">Reset</button>
      <div class="form-group row justify-content-center">
          <div class="text-center">
              <a href="register.php" class="btn btn-success">新規登録</a>
              <a href="login.php" class="btn btn-success">ログイン</a>
          </div>
      </div>
    </form>
  </div>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
