<?php
include '../../classes/User.php';
$user = new User;
session_start();

echo json_encode($user->get_activity_hours());
?>
