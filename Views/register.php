<?php
use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');
// $player = new PlayerController();
// $result = $player->checkLogin();
// if ($result) {
//     header('Location: index.php');
//     return;
// }

// $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
if (!empty($_POST) && empty($_SESSION['data'])) {
    $err = [];

    if (empty($_POST['name'])) {
        $err['name'] = '名前を入力してください。';
    }
    $mailCheck = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
    if (empty($_POST['email']) || !preg_match($mailCheck, $_POST['email'])) {
        $err['email'] = 'メールアドレスは正しくご入力ください。';
    }

    if (empty($_POST['password']) || !preg_match("/\A[a-z\d]{8,100}+\z/i", $_POST['password'])) {
        $err['password'] = 'パスワードは英数字８文字以上100文字以下にしてください。';
    }

    if ($_POST['password'] !== $_POST['password_conf']) {
        $err['password_conf'] = '確認用パスワードと異なっています。';
    }

    if (empty($err)) {
      // ユーザー登録処理
        $_SESSION['data'] = $_POST;
        $data = $_SESSION['data'];
        $params = new MountainController();
        $user = $params->register($data);

        header('Location:login.php');
    }
} elseif (!empty($_SESSION['data'])) {
    $_POST = $_SESSION['data'];
}

session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユーザー登録</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
  crossorigin="anonymous">
</head>
<body>
  <div class="container py-4" id="contact">
    <h2 class="text-center">ユーザー登録フォーム</h2>
    <?php echo isset($login_err) ? $login_err : ''; ?>
    <form action="register.php" method="POST">
      <div class="form-group">
        <label for ="name">Name<?php echo isset($err['name']) ? $err['name'] : ''; ?></label>
        <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="nameHelp"
        value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="form-group">
        <label for ="email">Email<?php echo isset($err['email']) ? $err['email'] : ''; ?></label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="form-group">
        <label for ="password">Password<?php echo isset($err['password']) ? $err['password'] : ''; ?></label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" aria-describedby="passwordHelp"
        value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="form-group">
        <label for ="password_conf">Password確認<?php echo isset($err['password_conf']) ? $err['password_conf'] : ''; ?></label>
        <input type="password" name="password_conf" class="form-control" id="exampleInputPassword_conf" aria-describedby="password_confHelp"
        value="<?php echo isset($_POST['password_conf']) ? htmlspecialchars($_POST['password_conf'], ENT_QUOTES) : ''; ?>">
      </div>
      <label for ="role"></label>
      <input type="hidden" name="role" value="0">
      <button type="submit" class="btn btn-success">登録</button>
    </form>
  </div>
  <div class="text-center">
    <a href="login.php" class="btn btn-success">ログイン</a>
  </div>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
  crossorigin="anonymous"></script>
</body>
</html>
