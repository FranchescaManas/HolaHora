<?php
include "../../classes/Admin.php";

$admin = new Admin;
$admin->create_manager($_POST);
?>