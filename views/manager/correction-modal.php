<div class="modal fade bd-example-modal-md" id="view-manager-correction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form action="" method="post">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="employee-name">Employee Name</h5>
                <input type="hidden" id="request_id" name="request_id">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-evenly mb-4">
                    <div class="col-4  p-0">
                        <label for="duration" class="control-label">Duration:</label>
                        <p id="duration">--:-- --</p>
                        <label class="control-label">Start Time:</label>
                        <div class="mb-3">
                            <input type="time" id="requested-start-time" step="1">
                            <small id="start-time-label">From: </small>
                            <small id="start-time"></small>
                        </div>
                    </div>
                    <div class="col-4  p-0">
                        <label for="start-time" class="control-label">Activity:</label>
                        <p id="activity">--</p>
                        <label for="requested_end_time" class="control-label">End Time:</label>
                        <div class="mb-3">
                            <input type="time" id="requested-end-time" step="1">
                            <span><small>From: </small></span><small id="end-time">From: </small>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-evenly mb-4">
                    <div class="col-10">
                        <textarea name="remarks" id="remarks" class="form-control h-100" placeholder="Add Remarks"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0" id="approval-footer">
                <div class="col-10 d-flex gap-2 justify-content-between" id="approval-buttons">
                    <button type="button" class="btn btn-danger flex-fill" id="reject_correction">Reject</button>
                    <button type="button" class="btn btn-success flex-fill" id="accept_correction">Accept</button>
                </div>
            </div>

        </div>
    </form>
  </div>
</div>