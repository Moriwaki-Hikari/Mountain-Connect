<?php
use Mountain\MountainController;

session_start();
require_once(ROOT_PATH .'Controllers/MountainController.php');
if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location:../login.php');
}

$params = new MountainController();
$result = $params->messageDelete();
header('Location:../events/message.php?id=' . $result['messageDelete']['event_id']);
