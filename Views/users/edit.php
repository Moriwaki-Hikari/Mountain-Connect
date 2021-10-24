<?php
use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');
if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$id = $_SESSION['login_user']['id'];
$params = new MountainController();
$index = $params->profile($id);

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
    if (empty($_POST['body'])) {
        $err['body'] = '本文を入力してください。';
    }
    if (empty($err)) {
        $_SESSION['data'] = $_POST;
        $data = $_SESSION['data'];
        $result = $params->profileUpdate($data, $id);
        unset($_SESSION['data']);
        header('Location:../users/index.php');
        exit();
    }
} elseif (!empty($_SESSION['data'])) {
    $_POST = $_SESSION['data'];
    unset($_SESSION['data']);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>プロフィール編集画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
  crossorigin="anonymous">
</head>
<body>
  <?php include(dirname(__FILE__) . '/header.php');?>
  <div class="container py-4" id="contact">
    <h1 class="text-center">プロフィール編集画面</h1>
    <form action="../users/edit.php?id=<?php echo $index['profile']['id'] ?>" method="POST">
      <div class="form-group">
        <label for ="name">name:<?php echo isset($err['name']) ? $err['name'] : ''; ?></label>
        <input type="text" name="name" class="form-control"
        value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>"
        placeholder="<?php echo $index['profile']['name']?>">
      </div>
      <div class="form-group">
        <label for ="body">body:<?php echo isset($err['body']) ? $err['body'] : ''; ?></label>
        <textarea name="body" class="form-control" value="<?php echo isset($_POST['body']) ? htmlspecialchars($_POST['body'], ENT_QUOTES) : ''; ?>"placeholder="<?php echo $index['profile']['body']?>"></textarea>
      </div>
      <div class="text-center">
        <input type="submit" class="btn btn-success" value="更新">
      </div>
    </form>
  </div>
  <div class="text-center">
    <a class="btn btn-success" href="../users/index.php">戻る</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
