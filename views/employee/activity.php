
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Activity Tracker</title>
</head>
<body>
<?php 
include '../shared/main-nav.php';
include '../shared/view-remark-modal.php';
?>

<div class="container-fluid mt-1 p-4">
    
       <div class="card w-75 my-auto mx-auto">
            <div class="card-header bg-white">
                <h1 class="display-5 text-center fw-bold mb-2">{Activity}</h1>
            </div>
            <div class="card-body">
                <div class="row justify-content-evenly">
                    <div class="col-4 px-0 py-4">
                        <div class="container border border-1">
                            <p class="display-6 text-center">--:--</p>
                        </div>
                        <form action="" method="post" class="d-flex flex-column " style="height:63vh">
                            <div class="align-items-start">
                                <select name="activity" id="" class="form-select w-100 my-3">
                                    <option value="" hidden>Select Current Activity</option>
                                    <option value="">Activity 1</option>
                                    <option value="">Activity 2</option>
                                    <option value="">Activity 3</option>
                                </select>
                                <button type="submit" class="form-control btn btn-primary mb-2">Update Activity</button>
                            </div>

                            <div class="mt-auto">
                                <button type="submit" class="form-control btn btn-success mb-2">Start Shift</button>
                                <button type="submit" class="form-control btn btn-danger">End Shift</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-7 px-0 mt-4" style="max-height: 70vh; overflow-y:auto">
                        <table class="table table-striped table-hover overflow-auto">
                            <thead class="table-dark">
                                <tr>
                                    <th>Activity</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>####</td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                            <i class="fa-regular fa-message"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Additional rows omitted for brevity -->
                            </tbody>
                        </table>
                    </div>
                </div>
        
            </div>
        </div> 
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
