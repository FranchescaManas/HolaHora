
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
include '../../classes/User.php';
include '../shared/main-nav.php';
include '../shared/view-remark-modal.php';


$user = new User;
?>

<div class="container-fluid mt-auto px-4">
    
       <div class="card w-75 my-auto mx-auto h-50">
            <div class="card-header bg-white">
                <h1 class="display-5 text-center fw-bold mb-2" id="activityTitle">Select Current Activity</h1>

            </div>
            <div class="card-body">
                <div class="row justify-content-evenly">
                    <div class="col-4 px-0 py-4">
                        <div class="container border border-1">
                            <p id="currentTime" class="display-6 text-center">--:--</p>
                        </div>
                        <form action="" method="post" class="d-flex flex-column " style="height:57vh">
                            <?php
                            $activities = $user->get_activity();
                            
                            
                            ?>
                            <div class="align-items-start">
                                <select name="activity" id="activitySelect" class="form-select w-100 my-3">
                                    <option value="" hidden>Select Current Activity</option>
                                    <?php while ($activity = $activities->fetch_assoc()) { ?>
                                        <option value="<?= $activity['activity_id'] ?>"><?= $activity['activity_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="form-control btn btn-primary mb-2">Update Activity</button>
                            </div>

                            <div class="mt-auto">
                                <!-- TODO: fix tranferring of data through forms -->
                                <form action="../../actions/employee/shift-activity.php" method="post" class="px-0">
                                    <button type="submit" class="form-control btn btn-success mb-2" name="shift" value = "1">Start Shift</button>
                                    <button type="submit" class="form-control btn btn-danger" name="shift" value = "0">End Shift</button>
                                </form>
                            </div>
                        </form>
                    </div>
                    <div class="col-7 px-0 mt-4" style="max-height: 65vh; overflow-y:auto">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // When the select dropdown changes
        $("#activitySelect").change(function () {
            // Get selected option text
            var selectedActivity = $(this).find("option:selected").text();
            
            // Update the <h1> element
            $("#activityTitle").text(selectedActivity);
        });
    });

    function updateTime() {
        var now = new Date();
        var hours = now.getHours().toString().padStart(2, '0'); // Format hours (00-23)
        var minutes = now.getMinutes().toString().padStart(2, '0'); // Format minutes (00-59)
        var seconds = now.getSeconds().toString().padStart(2, '0'); // Format seconds (00-59)

        var formattedTime = hours + ":" + minutes + ":" + seconds;
        document.getElementById("currentTime").textContent = formattedTime;
    }

    // Update time every second
    setInterval(updateTime, 1000);

    // Initial call to display time immediately
    updateTime();
</script>
</body>
</html>
