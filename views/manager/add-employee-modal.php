<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Add Employees to Team</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <!-- Search -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="search_employee_modal" placeholder="Search Employee...">
          <button class="btn btn-outline-secondary" type="button" id="clear_search">Clear</button>
        </div>
        <div id="employee_list_modal" class="dropdown-menu w-100"></div>

        <!-- Team Dropdown -->
        <div class="mb-3">
          <label for="team_select" class="form-label">Select Team</label>
          <select class="form-select" id="team_select">
            <option value="" hidden>Select Team</option>
            <?php
            $teams = $manager->get_manager_teams();
            while ($team = $teams->fetch_assoc()) { ?>
              <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <!-- Selected Employees Table -->
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Employee Name</th>
              <th>Position</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="selected_employees_table">
            <!-- Dynamically filled -->
          </tbody>
        </table>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_team_employees">Save</button>
      </div>
    </div>
  </div>
</div>
