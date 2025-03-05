<div class="modal fade bd-example-modal-lg" id="correction-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="" method="post">
        <div class="modal-content p-3">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Activity Correction</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row justify-content-evenly mb-4">
                <div class="col-4  ">
                    <label for="start-time" class="control-label">Activity:</label>
                    <p>Activity #</p>
                    <label for="start-time" class="control-label">Start Time:</label>
                    <p>--:-- --</p>
                    <label for="end-time" class="control-label">End Time:</label>
                    <p>--:-- --</p>
                    <label for="duration" class="control-label">Duration:</label>
                    <p>--:-- --</p>
                </div>
                <div class="col-8  ">
                    <textarea name="remarks" id="" class="form-control h-100" placeholder="Add Remarks"></textarea>
                </div>
            </div>
            
            <div class="row">
                <p class="m-0 p-0">Following Activity:</p>
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <th>Activity</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                    </thead>
                    <tbody>
                        <td>Activity</td>
                        <td>Start Time</td>
                        <td>End Time</td>
                        <td>Duration</td>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer justify-content-between border-0">
            <p><u>Request to: {{Manager}}</u></p>
            <button type="button" class="btn btn-primary" name="btn_save">Save</button>
        </div>
        </div>
    </form>
  </div>
</div>