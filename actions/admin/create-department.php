<?php
include "../../classes/Admin.php";


$admin = new Admin;

$admin->create_department($_POST);
?>