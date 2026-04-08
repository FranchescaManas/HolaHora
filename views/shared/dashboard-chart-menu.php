
<?php

include "../../classes/User.php";
$user = new User;
$activities_result = $user->get_activity();
$activities = [];

while ($row = $activities_result->fetch_assoc()) {
    $activities[] = $row;
}

$i = 0;

// while ($i < count($activities)) {
//     echo $activities[$i]['activity_name'] . "<br>";
//     $i++;
// }

if ($role == 'A'){
    include "../../classes/Admin.php";
    $admin = new Admin;
    $teams = $admin->get_teams();
    $employees = $admin->get_all_employees();
    include "../admin/activity-modal.php";
    ?>
   <form id="dashboardFilter" class="row g-2 mb-3 w-100 align-items-center">


    <!-- MAIN ROW -->
    <div class="row g-2 align-items-center">

        <!-- Name -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="name_filter" class="form-select form-select-sm">
                <option value="">All Employees</option>
                <?php while ($employee = $employees->fetch_assoc()): ?>
                    <option value="<?= (int)$employee['user_id'] ?>">
                        <?= htmlspecialchars($employee['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Team -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="team_filter" class="form-select form-select-sm">
                <option value="">All Teams</option>
                <?php while ($team = $teams->fetch_assoc()): ?>
                    <option value="<?= (int)$team['team_id'] ?>">
                        <?= htmlspecialchars($team['team_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Activity -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="activity" class="form-select form-select-sm">
                <option value="">All Activities</option>
                <?php foreach ($activities as $activity): ?>
                    <option value="<?= (int)$activity['activity_id'] ?>">
                        <?= htmlspecialchars($activity['activity_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Actions -->
        <div class="col-auto ms-auto d-flex gap-2">

            <!-- Advanced Filters Dropdown -->
            <div class="dropdown">
                <button type="button"
                    class="btn btn-outline-secondary btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside">
                    <i class="fa fa-sliders-h me-1"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end p-3">

                    <!-- Date -->
                    <label class="form-label small mb-1">From</label>
                    <input type="date" name="from" class="form-control form-control-sm mb-2">

                    <label class="form-label small mb-1">To</label>
                    <input type="date" name="to" class="form-control form-control-sm mb-3">
                    
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch"
                            name="is_billable" value="1" id="isBillable">
                        <label class="form-check-label small" for="isBillable">
                            Billable Only
                        </label>
                    </div>
                    <hr class="my-2">
                    

                    <!-- Export -->
                    <button id="exportCsv" class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fa fa-file-csv me-1"></i> Export
                    </button>

                    
                </div>
            </div>
            
            <!-- Create -->
            <button type="button" class="btn btn-primary btn-sm w-100"
                data-bs-toggle="modal" data-bs-target="#actitiviesModal">
                <i class="fas fa-plus-circle"></i> 
            </button>
            <!-- Filter Submit -->
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-filter"></i>
            </button>
        </div>


    </div>


</form>


    <?php
} else if ($role == "E"){
    include '../../classes/Employee.php';
    ?>
    <form id="dashboardFilter" class="row g-2 mb-3 w-100 align-items-center">
    
    <!-- Activity Dropdown -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <select name="activity" class="form-select form-select-sm">
            <option value="">All Activities</option>

            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                    <option value="<?= (int)$activity['activity_id'] ?>">
                        <?= htmlspecialchars($activity['activity_name']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
    </div>

   <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dropdown w-100">
            <button
                class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <span>
                    <i class="fa-regular fa-calendar me-1"></i>
                    Date Range
                </span>
            </button>

            <div class="dropdown-menu p-3" style="min-width: 260px;">
                <!-- From -->
                <div class="mb-2">
                    <label class="form-label small">From</label>
                    <input type="date" name="from" class="form-control form-control-sm">
                </div>

                <!-- To -->
                <div>
                    <label class="form-label small">To</label>
                    <input type="date" name="to" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="col-lg-2 col-md-12 col-sm-12">
        <button type="submit" class="btn btn-primary btn-sm w-100" title="Apply filters">
            <i class="fa-solid fa-filter"></i>
        </button>

    </div>

</form>



    <?php
   
}else if ($role == "M"){
    include '../../classes/Manager.php';
    $manager = new Manager();
    $teams = $manager->get_manager_teams();
    $employees = $manager->get_team_employees();
    ?>
    <form id="dashboardFilter" class="row g-2 mb-3 w-100 align-items-center">
        <!-- MAIN ROW -->
    <div class="row g-2 align-items-center">

        <!-- Name -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="name_filter" class="form-select form-select-sm">
                <option value="">All Employees</option>
                <?php while ($employee = $employees->fetch_assoc()): ?>
                    <option value="<?= (int)$employee['user_id'] ?>">
                        <?= htmlspecialchars($employee['employee_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Team -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="team_filter" class="form-select form-select-sm">
                <option value="">All Teams</option>
                <?php while ($team = $teams->fetch_assoc()): ?>
                    <option value="<?= (int)$team['team_id'] ?>">
                        <?= htmlspecialchars($team['team_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Activity -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <select name="activity" class="form-select form-select-sm">
                <option value="">All Activities</option>
                <?php foreach ($activities as $activity): ?>
                    <option value="<?= (int)$activity['activity_id'] ?>">
                        <?= htmlspecialchars($activity['activity_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Actions -->
        <div class="col-auto ms-auto d-flex gap-2">

            <!-- Advanced Filters Dropdown -->
            <div class="dropdown">
                <button type="button"
                    class="btn btn-outline-secondary btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside">
                    <i class="fa fa-sliders-h me-1"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end p-3">

                    <!-- Date -->
                    <label class="form-label small mb-1">From</label>
                    <input type="date" name="from" class="form-control form-control-sm mb-2">

                    <label class="form-label small mb-1">To</label>
                    <input type="date" name="to" class="form-control form-control-sm mb-3">
                    
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch"
                            name="is_billable" value="1" id="isBillable">
                        <label class="form-check-label small" for="isBillable">
                            Billable Only
                        </label>
                    </div>
                    <hr class="my-2">
                    

                    <!-- Export -->
                    <button id="exportCsv" class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fa fa-file-csv me-1"></i> Export
                    </button>

                    
                </div>
            </div>
        
            <!-- Filter Submit -->
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-filter"></i>
            </button>
        </div>


    </div>

</form>



    <?php
}

?>
    
