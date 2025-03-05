<div class="modal fade" id="create-department" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Department</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
          <form action="../../actions/admin/create-department.php" method="post">
            <div class="row gx-2 mb-5">
                    <div class="col">
                        <input type="text" name="department" class="form-control" placeholder="Add a new department here..." required autofocus>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info w-100 fw-bold" name="btn_add">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </form>
            <div class="row gx-2">
                <table class="table table-sm align-middle text-center">
                    <thead class="table-dark">
                        <th>Department</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php
                    $all_departments = $admin->get_department();

                    while($department = $all_departments->fetch_assoc()){
                    ?>
                        <tr>
                            <td><?= $department['department_name']; ?></td>
                            <td>
                                <a href="" class="btn btn-outline-danger border-0"><i class="fa-solid fa-trash-can"></i></a>
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