
<?php

$role = "admin";

if ($role == 'admin'){
    ?>
    <div class="dropdown">

        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            Filter
        </button>
        <form class="dropdown-menu p-4">
            <div class="mb-3">
            <label for="exampleDropdownFormEmail2" class="form-label">Department</label>
            <select name="team_filter" id="" class="form-select">
                <option value="" hidden>Select Department</option>
                <option value="" >Department 1</option>
                <option value="" >Department 2</option>
                <option value="" >Department 3</option>
                <option value="" >Department 4</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="exampleDropdownFormEmail2" class="form-label">Team</label>
            <select name="team_filter" id="" class="form-select">
                <option value="" hidden>Select Team</option>
                <option value="" >Team 1</option>
                <option value="" >Team 2</option>
                <option value="" >Team 3</option>
                <option value="" >Team 4</option>
            </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">End Date</label>
                <input type="date" name="end_date" id="" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <?php
} else if ($role == "Employee"){
    ?>
    <div class="d-flex justify-content-between">

        <a href="" class="btn btn-primary">Correction</a>
        <button type="button" class="btn btn-primary">Date Range Filter</button>
        <button type="button" class="btn btn-primary">Export</button>
    </div>
    <?php
}

?>
    
