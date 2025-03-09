<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
    
</head>
<body class="border border-1 border-danger bg-light" style="height: 100vh">
<?php 
include '../shared/main-nav.php';
include 'create-employee-modal.php';
?>

<div class="container w-75 h-75 bg-white border rounded-3 p-3">
    <div class="row justify-content-end mb-3 mx-1">
        <input type="text" class="form-control w-25 ">
        <button class="btn btn-primary w-auto ms-2">Add Employee</button>
        <button class="btn btn-primary w-auto ms-2"  data-bs-toggle="modal" data-bs-target="#create-employee-modal">Create Employee</button>

    </div>
    <div class="row">
        <div class="col-4">
            <div class="mb-3">
                <label for="manager" class="form-label">Manager</label>
                <select name="manager" id="" class="form-select">
                    <option value="" hidden>Manager</option>
                    <option value="">Manager 1</option>
                    <option value="">Manager 2</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department:</label>
                <select name="department" id="" class="form-select">
                    <option value="" hidden>Department</option>
                    <option value="">Department 1</option>
                    <option value="">Department 2</option>
                </select>
            </div>

            <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
                <select name="status" id="" class="form-select">
                    <option value="" hidden>Status</option>
                    <option value="">Active</option>
                    <option value="">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <th>Employee Name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <td class="align-middle">Employee 1</td>
                    <td class="align-middle">Position 1</td>
                    <td class="align-middle">Active</td>
                    <td>
                        <button class="btn bg-none border-0" data-bs-toggle="modal" data-bs-target="#employee-modal">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </button>
                    
                        <button class="btn bg-none border-0">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    
                        <button class="btn bg-none border-0">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>