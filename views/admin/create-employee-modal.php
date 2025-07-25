<div class="modal fade" id="create-employee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
        <form method="post" action="../../actions/admin/create-employee.php">
          <?php
          $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
          $lastpage = basename($path);

          ?>
          <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" name="contact">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                
            </div>
            <div class="col">
                

                <?php if ($lastpage !== "create-team.php") { ?>
                    <div class="mb-3">
                        <label for="team" class="form-label">Team:</label>
                        <select name="team" id="" class="form-select">
                            <option value="" hidden>Optional</option>
                            <?php foreach ($teams as $team) { ?>
                                <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="team_id" value="default">
                <?php } ?>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" name="position">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-5 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
          </div>
          
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div> -->
    </div>
  </div>
</div>