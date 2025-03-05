 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
    
 </head>
 <body class="border border-1 border-danger" style="height: 100vh">

   <?php include "../shared/main-nav.php";?>
   <div class="container h-75 w-75 border border-1 border-primary">
      
         
         <div class="row justify-content-end mb-2">
            <input type="text" name="add_employee" id="" class="form-control w-25">
            <button type="submit" class="btn btn-primary w-auto ms-2">Add</button>
            <div class="dropdown w-auto px-0 ms-2">
               <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  <i class="fa-solid fa-filter"></i>
               </button>
               <form class="dropdown-menu p-4">
                  <div class="mb-3">
                     <label for="exampleDropdownFormEmail2" class="form-label">Status</label>
                     <select name="team_filter" id="" class="form-select">
                        <option value="" hidden>Select Status</option>
                        <option value="" >Active</option>
                        <option value="" >Inactive</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="exampleDropdownFormEmail2" class="form-label">Position</label>
                     <select name="team_filter" id="" class="form-select">
                        <option value="" hidden>Select Position</option>
                        <option value="" >Position 1</option>
                        <option value="" >Position 2</option>
                        <option value="" >Position 3</option>
                        <option value="" >Position 4</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="exampleDropdownFormEmail2" class="form-label">Team</label>
                     <select name="team_filter" id="" class="form-select">
                        <option value="" hidden>Select Team</option>
                        <option value="" >Team 1</option>
                        <option value="" >Team 2</option>
                        <option value="" >Team 3</option>
                        <option value="" >Team 4</option>
                     </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
               </form>
            </div>
         </div>

         <div class="row">
            <table class="table table-hover table-striped">
               <thead class="table-dark">
                  <th>Employee Name</th>
                  <th>Status</th>
                  <th>Position</th>
                  <th>Team</th>
                  <th></th>
               </thead>
               <tbody>
                  <td class="align-middle">Employee 1</td>
                  <td class="align-middle">Active</td>
                  <td class="align-middle">Position 1</td>
                  <td class="align-middle">Team 1</td>
                  <td>
                     <button class="btn bg-none border-0" data-bs-toggle="modal" data-bs-target="#employee-modal">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                     </button>
                 
                     <button class="btn bg-none border-0">
                        <i class="fa-regular fa-pen-to-square"></i>
                     </button>
                  
                     <button class="btn bg-none border-0">
                        <i class="fa-solid fa-trash"></i>
                     </button>
                  </td>
               </tbody>
            </table>
         </div>
         

   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </body>
 </html>