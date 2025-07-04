<!-- Modal for Editing Employee -->
<div class="modal fade" id="edit-employee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="../../actions/user/edit-employee.php">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Hidden user ID -->
          <input type="hidden" name="user_id" id="edit-user-id">

          <div class="row">
            <div class="col">
              <label for="edit-firstname" class="form-label">First Name</label>
              <input type="text" class="form-control mb-3" id="edit-firstname" name="firstname">

              <label for="edit-lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control mb-3" id="edit-lastname" name="lastname">

              <label for="edit-contact" class="form-label">Contact No.</label>
              <input type="text" class="form-control mb-3" id="edit-contact" name="contact">

              <label for="edit-username" class="form-label">Username</label>
              <input type="text" class="form-control mb-3" id="edit-username" name="username">
            </div>
            <div class="col">
              <label for="edit-email" class="form-label">Email</label>
              <input type="email" class="form-control mb-3" id="edit-email" name="email">
              <!-- Position ComboBox -->
              <label for="edit-position" class="form-label">Position</label>
              <input list="position-options" class="form-control mb-3" id="edit-position" name="position">
              <datalist id="position-options">
                <?php foreach ($positions as $position): ?>
                  <option value="<?= htmlspecialchars($position) ?>">
                <?php endforeach; ?>
              </datalist>

              <!-- Team ComboBox -->
              <label for="edit-team" class="form-label">Team</label>
              <input list="team-options" class="form-control mb-3" id="edit-team" name="team">
              <datalist id="team-options">
                <?php foreach ($teams as $team): ?>
                  <option value="<?= htmlspecialchars($team) ?>">
                <?php endforeach; ?>
              </datalist>

            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
