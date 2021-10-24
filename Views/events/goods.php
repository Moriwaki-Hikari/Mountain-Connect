<?php //phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
session_start();
require_once(ROOT_PATH .'/Models/Good.php');

if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new Good\Good();
if (isset($_POST['eventId'])) {
    $event_id = $_POST['eventId'];
    $user_id = $_SESSION['login_user']['id'];
    $result = $params -> checkGood($event_id, $user_id);
    echo $result;
}
