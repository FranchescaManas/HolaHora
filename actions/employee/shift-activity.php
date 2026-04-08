<?php
include "../../classes/Employee.php";


$employee = new employee;

// Check which action was triggered
if (isset($_POST['btn_activity'])) {
    $isUpdated = $employee->update_activity($_POST);
    
    if ($isUpdated) {
        echo "<script>
                alert('Activity updated successfully.');

            </script>";
    } else {
        echo "<script>
                alert('Failed to update activity.');
            </script>";
    }
    echo "<script>
            window.location.href = '../../views/employee/activity.php';
        </script>";

} elseif (isset($_POST['btn_shift'])) {
    $shift_type = $_POST["btn_shift"];
    $employee->shift($_POST);
} else {
    die("Invalid request.");
}
?>