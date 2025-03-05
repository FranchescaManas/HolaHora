<div class="modal fade" id="view-remark" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Activity</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row justify-content-evenly">
                <div class="col-3  ">
                    <label for="start-time" class="control-label">Start Time:</label>
                    <p>--:-- --</p>
                    <label for="end-time" class="control-label">End Time:</label>
                    <p>--:-- --</p>
                    <label for="duration" class="control-label">Duration:</label>
                    <p>--:-- --</p>
                </div>
                <div class="col-9  ">
                    <textarea name="remarks" id="" class="form-control h-100" placeholder="Add Remarks"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" name="btn_save">Save</button>
        </div>
        </div>
    </form>
  </div>
</div>