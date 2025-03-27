<div class="modal fade" id="view-remark" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="remarkForm" method="post">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Activity Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="row justify-content-evenly">
            
            <!-- Hidden Entry ID -->
            <input type="hidden" name="entry_id" id="entry_id">

            <!-- Activity Details -->
            <div class="col-3">
              <label class="control-label">Start Time:</label>
              <p id="start-time">--:-- --</p>

              <label class="control-label">End Time:</label>
              <p id="end-time">--:-- --</p>

              <label class="control-label">Duration:</label>
              <p id="duration">--:-- --</p>
            </div>

            <!-- Remarks Section -->
            <div class="col-9">
              <textarea name="remarks" id="remarks" class="form-control h-100" placeholder="Add Remarks"
                <?= ($role != 'E') ? 'disabled readonly' : ''; ?>></textarea>
            </div>

          </div>
        </div>

        <!-- Modal Footer (Only for Employees) -->
        <?php if ($role == 'E') : ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveRemark">Save</button>
        </div>
        <?php endif; ?>

      </div>
    </form>
  </div>
</div>
