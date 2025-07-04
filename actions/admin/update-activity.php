<?php
require_once '../../classes/Admin.php';

$admin = new Admin;

if (isset($_POST['activity_id'], $_POST['activity_name'], $_POST['isBillable'])) {
  
    $activity_id = $_POST['activity_id'];
    $activity_name = $_POST['activity_name'];
    $isBillable = $_POST['isBillable'];

    $result = $admin->update_activity($activity_id, $activity_name, $isBillable);


    echo $result ? "success" : "error";
    
}
?>
