<?php
session_start();

require_once(ROOT_PATH .'vendor/autoload.php');
require_once(ROOT_PATH .'/Models/User.php');

if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

// $params = new MountainController();
// $result = $params->checkLogin();
// if ($result) {
//     header('Location: index.php');
//     return;
// }
$id_token = filter_input(INPUT_POST, 'id_token');
define('CLIENT_ID', '1089148462358-o57v7mcn0haug04l9b1vg86ekvj4ahhi.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]);

$payload = $client->verifyIdToken($id_token);
//$payload = $client->addScope("email");

if ($payload) {
    $email = $payload['email'];
    $user_name = $payload['name'];
    $params = new User\User();
    $result = $params->googleLogin($email, $user_name);
}




$_SESSION['login_user'] = $result;
header('Location:../events/login.php');
exit;
