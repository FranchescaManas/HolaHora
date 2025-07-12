<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    
</head>
<body class="border border-1 border-danger bg-light" style="height: 100vh">
<?php 
include '../shared/main-nav.php';
include '../shared/view-employee-modal.php';
include '../../classes/Admin.php';

$admin = new Admin;
$team_id = $_GET['team_id'];

$team_data = $admin->get_specific_team($team_id);
$employees = $admin->get_specific_team_employees($team_id);
$all_manager = $admin->get_manager();
$all_department = $admin->get_department();
$assigned_manager_id = $team_data['user_id'] ?? null;
$assigned_department_id = $team_data['department_id'] ?? null;
$assigned_status = $team_data['status'];

?>

<div class="container w-75 h-75 bg-white border rounded-3 p-3 d-flex flex-column">
    <form action="../../actions/admin/edit-team.php" method="post" class="d-flex flex-column h-100">
        
        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <label for="team" class="form-label">Team Name:</label>
                    <input type="text" name="team_name" id="team" class="form-control" value="<?= $team_data['team_name']?>">
                </div>

                <div class="mb-3">
                    <label for="manager" class="form-label">Manager</label>
                    <select name="manager" id="manager" class="form-select">
                        <?php while ($manager = $all_manager->fetch_assoc()): ?>
                            
                            <option value="<?= $manager['user_id'] ?>" 
                                <?= ($manager['user_id'] == $assigned_manager_id) ? 'selected' : '' ?>>
                                <?= $manager['firstname'] . ' ' . $manager['lastname'];?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="department" class="form-label">Department:</label>
                    <select name="department" id="department" class="form-select">
                        <?php while ($department = $all_department->fetch_assoc()): ?>
                            <option value="<?= $department['department_id'] ?>" 
                                <?= ($department['department_id'] == $assigned_department_id) ? 'selected' : '' ?>>
                                <?= $department['department_name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>


                <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                   <select name="status" id="" class="form-select">
                        <option value="" hidden>Status</option>
                        <option value="Active" <?= ($assigned_status === 'Active') ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= ($assigned_status === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col">
               <table class="table table-hover table-striped" id="team_employee_list">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr data-user-id="<?= $employee['user_id']; ?>">
                                <td class="align-middle"><?= $employee['name']; ?></td>
                                <td class="align-middle"><?= $employee['position']; ?></td>
                                <td class="align-middle"><?= $employee['status']; ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btn-sm view-employee" data-bs-toggle="modal" data-bs-target="#view-employee-modal"
                                        data-user-id="<?=$employee['user_id']; ?>" 
                                        >
                                        View
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <input type="hidden" name="team_id" value="<?= $team_id?>">
                <input type="hidden" name="employees[]" id="employees">
            </div>
        </div>
        
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../../assets/js/shared/employee-detail.js"></script>

</body>
</html>