<!-- Modal for Viewing Employee (Read-Only) -->
<div class="modal fade" id="view-employee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Employee Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Employee Details Displayed Here (Read-Only) -->
        <div class="row">
          <div class="col">
            <label for="view-firstname" class="form-label">First Name</label>
            <input type="text" class="form-control mb-3" id="view-firstname" disabled> <!-- Disabled field -->
            
            <label for="view-lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control mb-3" id="view-lastname" disabled> <!-- Disabled field -->

            <label for="view-contact" class="form-label">Contact No.</label>
            <input type="text" class="form-control mb-3" id="view-contact" disabled> <!-- Disabled field -->
            <label for="view-username" class="form-label">Username</label>
            <input type="text" class="form-control mb-3" id="view-username" disabled> <!-- Disabled field -->
          </div>
          <div class="col">
            <label for="view-email" class="form-label">Email</label>
            <input type="email" class="form-control mb-3" id="view-email" disabled> <!-- Disabled field -->
            
            <label for="view-position" class="form-label">Position</label>
            <input type="text" class="form-control mb-3" id="view-position" disabled> <!-- Disabled field -->

            <label for="view-team" class="form-label">Team</label>
            <input type="text" class="form-control mb-3" id="view-team" disabled> <!-- Disabled field -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
