<div class="modal fade" id="create-manager-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Manager</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="../../actions/admin/create-manager.php">
          <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="text form-control" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="text form-control" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact No.</label>
                    <input type="text" class="text form-control" name="contact">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="text form-control" name="email">
                </div>
            </div>
            <div class="col">
                
                <div class="mb-3">
                    <label for="department" class="form-label">Department:</label>
                    <select name="department" id="1" class="form-select">
                        <option value="" hidden>Assign Department (optional)</option>
                        <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department['department_id'] ?>"><?= $department['department_name'] ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="team" class="form-label">Team:</label>
                    <select name="team" id="" class="form-select">
                      <option value="" hidden>Assign Team (optional)</option>
                      <?php foreach ($teams as $team) { ?>
                        <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?></option>
                      <?php } ?>
                    </select>
                </div>
              
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="text form-control" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="text form-control" name="password">
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