<?php
include "../../classes/Admin.php";


$admin = new Admin;
$team_id = $_GET['team_id'];

$admin->delete_team($team_id);
?>