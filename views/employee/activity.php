<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Activity Tracker</title>
</head>
<body>
<?php 

include '../shared/main-nav.php';
include '../../classes/Employee.php';
include '../../classes/User.php';
include '../shared/view-remark-modal.php';


$user = new User;
$employee = new Employee; 
$isShiftActive = $employee->get_ShiftActive(); // true or false

?>

<div class="container-fluid mt-auto px-4">
    
       <div class="card w-75 my-auto mx-auto h-50">
            <div class="card-header bg-white">
                <h1 class="display-5 text-center fw-bold mb-2" id="activityTitle" data-shift="<?= $isShiftActive ? '1' : '0' ?>">Select Current Activity</h1>

            </div>
            <div class="card-body">
                <div class="row justify-content-evenly">
                    <div class="col-4 px-0 py-4">
                        <form action="../../actions/employee/shift-activity.php" method="post" onsubmit="set_time_activity()">
                            <div class="container border border-1">
                                <p id="currentTime" class="display-6 text-center">--:--</p>
                            </div>
                            <div class="d-flex flex-column " style="height:57vh">
                            <?php
                            $activities = $user->get_activity();
                            
                            // print($isShiftActive ? 'true' : 'false');
                            
                            ?>
                                <div class="align-items-start">

                                    <select name="activity" class="form-select w-100 my-3">
                                        <option value="" hidden>Select Current Activity</option>
                                        <?php while ($activity = $activities->fetch_assoc()) { ?>
                                            <option value="<?= $activity['activity_id'] ?>"><?= $activity['activity_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- Hidden Input to store the current time -->
                                    <input type="hidden" name="time" id="timeInput">
                                    <button type="submit" class="form-control btn btn-primary mb-2" name="btn_activity" id="activitySelect">Update Activity</button>
                                </div>
                                
                                <div class="mt-auto">
                                    
                                    <button type="button" class="form-control btn btn-success mb-2" 
                                        onclick="submitShift(1)" <?= $isShiftActive ? 'disabled' : '' ?>>
                                        Start Shift
                                    </button>

                                    <button type="button" class="form-control btn btn-danger" 
                                        onclick="submitShift(0)" <?= !$isShiftActive ? 'disabled' : '' ?>>
                                        End Shift
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-7 px-0 mt-4" style="max-height: 65vh; overflow-y:auto">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Activity Name</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 

                                 $activities = $employee->get_activities();
                                if ($activities) { ?>
                                    <?php while ($log = $activities->fetch_assoc()) { 
                                        // print_r($log);
                                        ?>
                                        
                                        <tr>
                                            <td><?= $log['activity_name'] ?></td>
                                            <td><?= $log['date'] ?></td>
                                            <td><?= $log['start_time'] ?></td>
                                            <td><?= $log['end_time'] ?? 'Ongoing' ?></td>
                                            <td><?= $log['duration'] ?? 'In Progress' ?></td>
                                            <td>
                                                <button type="button" class="btn view-remark-btn" data-bs-toggle="modal" data-bs-target="#view-remark" data-entry-id="<?= $log['entry_id'] ?>">
                                                    <i class="fa-regular fa-message"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No activities recorded</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                       
                    </div>
                </div>
        
            </div>
        </div> 
    </div>
</div>
<?php
include './shift-modal.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../../assets/js/employee/activity.js"></script>
<script src="../../assets/js/shared/activity-modal.js"></script>
</body>
</html>
