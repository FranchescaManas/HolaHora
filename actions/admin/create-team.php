<?php
include "../../classes/Admin.php";


$admin = new Admin;
// Ensure `employees` is always an array
// $employees = isset($_POST['employees']) ? $_POST['employees'] : [];

// print_r($_POST);
$result = $admin->create_team($_POST);

if ($result[0]) {
    echo "<script>
            alert('Team created successfully!');
            window.location.href='../../views/admin/team-management.php';
          </script>";
} else {
    echo "<script>
            alert('Error creating team: ".$result[1]."');
            window.location.href='../../views/admin/team-management.php';
          </script>";
}
?>