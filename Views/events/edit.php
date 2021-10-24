<?php
use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');
if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new MountainController();
$result = $params->getMyEvent();
$id = $result['getMyEvent']['id'];
// if ($result) {
//     header('Location: index.php');
//     return;
// }
// $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
if (!empty($_POST) && empty($_SESSION['data'])) {
    $err = [];

    if (empty($_POST['title'])) {
        $err['title'] = 'タイトルを入力してください。';
    }
    if (empty($_POST['body'])) {
        $err['body'] = '本文を入力してください。';
    }
    if (empty($err)) {
      // ユーザー登録処理
        $_SESSION['data'] = $_POST;
        $data = $_SESSION['data'];
        $params->eventsUpdate($data, $id);
        unset($_SESSION['data']);
        header('Location:../events/myevent.php');
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
  <title>イベント編集画面</title>
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
    <h1 class="text-center">イベント編集画面</h1>
    <form action="edit.php?id=<?php echo $result['getMyEvent']['id'] ?>" method="POST">
      <div class="form-group">
        <label for ="title">title:<?php echo isset($err['title']) ? $err['title'] : ''; ?></label>
        <input type="text" name="title" class="form-control"
        value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES) : ''; ?>"
        placeholder="<?php echo $result['getMyEvent']['title']?>">
      </div>
      <div class="form-group">
        <label for ="body">body:<?php echo isset($err['body']) ? $err['body'] : ''; ?></label>
        <textarea name="body" class="form-control" value="<?php echo isset($_POST['body']) ? htmlspecialchars($_POST['body'], ENT_QUOTES) : ''; ?>" placeholder="<?php echo $result['getMyEvent']['body']?>"></textarea>
      </div>
      <input type="submit" class="btn btn-success" value="更新">
    </form>
  </div>
  <div class="text-center">
    <a href="../events/myevent.php" class="btn btn-success">戻る</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
