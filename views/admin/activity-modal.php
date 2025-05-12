<div class="modal fade " id="actitiviesModal" tabindex="-1" aria-labelledby="activitiesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Billable Activities</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border p-4">
        <div class="row ">
          <form action="../../actions/admin/create-activity.php" method="post" class="d-flex justify-content-end px-0">
            <input type="text" name="activity_name" class="form-control w-25" placeholder="Enter activity name">
            <button type="submit" class="btn btn-primary px-2 w-auto ms-2">Add</button>
          </form>
        </div>
        <div class="row mt-3">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <th>Activity Name</th>
              <th>Is Billable</th>
              <th></th>
            </thead>
            <tbody>
              <?php
               
              $activities = $user->get_activity();
              while($activity = $activities->fetch_assoc()){
              ?>
              <tr data-id="<?= $activity['activity_id'] ?>">
                  <td class="align-middle activity-name"><?= $activity['activity_name']?></td>
                  <td class="align-middle">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" <?= $activity['isBillable'] == 1 ? 'checked' : '' ?> disabled>
                    </div>
                  </td>
                  <td>
                    <button class="btn bg-none border-0 edit-activity-btn">
                      <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <button class="btn bg-none border-0 save-activity-btn d-none">
                      <i class="fa-solid fa-check"></i>
                    </button>
                    <a href="../../actions/admin/delete-activity.php?activity_id=<?=$activity['activity_id']?>" class="btn bg-none border-0">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
              </tr>

              <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </div>
</div>