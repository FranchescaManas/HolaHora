<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="border border-1 border-danger bg-light" style="height: 100vh">
<?php 
include '../shared/main-nav.php';
include 'create-employee-modal.php';

include '../../classes/Admin.php';

$admin = new Admin;

$all_manager = $admin->get_manager();
$all_department = $admin->get_department();

$team_list = [];


?>

<div class="container w-75 h-75 bg-white border rounded-3 p-3">
    <form action="../../actions/admin/create-team.php" method="post" class="d-flex flex-column h-100">
        <div class="container h-75">
            <div class="row justify-content-end mb-3 mx-1">
            <input type="text" class="form-control w-25" name="search_employee" id="search_employee" placeholder="Search Employee...">
            <div id="employee_list" class="dropdown-menu w-25"></div>
            <button class="btn btn-primary w-auto ms-2" id="add_employee">Add Employee</button>
                <button type="button" class="btn btn-primary w-auto ms-2" data-bs-toggle="modal" data-bs-target="#create-employee-modal">Create Employee</button>
            </div>
            <div class="row h-100">
            <div class="col-4 h-100">
                <div class="mb-3">
                    <label for="manager" class="form-label">Team Name:</label>
                    <input type="text" name="team_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="manager" class="form-label">Manager</label>
                    <select name="manager" id="" class="form-select">
                        <option value="" hidden>Manager</option>
                    <?php
                    while($manager = $all_manager->fetch_assoc()){
                    ?>
                        <option value="<?= $manager['user_id']?>"><?= $manager['firstname'] . ' ' . $manager['lastname'] . $manager['user_id']?></option>

                    <?php
                    }
                    ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department:</label>
                    <select name="department" id="" class="form-select">
                        <option value="" hidden>Department</option>
                        <?php
                        while($department = $all_department->fetch_assoc()){
                        ?>
                            <option value="<?= $department['department_id']?>"><?= $department['department_name']?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                    <select name="status" id="" class="form-select">
                        <option value="" hidden>Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col border border px-0">
                <table class="table table-hover table-striped" id="team_employee_list">
                    <thead class="table-dark">
                        <th>Employee Name</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                       
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
        </div>
       
        
        <!-- Hidden input to store selected employee IDs -->
        <input type="hidden" name="employees[]" id="employees">

        <div class="row border align-self-center w-100 mt-auto">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div> 
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../../assets/js/admin/create-team.js"></script>

</body>
</html>