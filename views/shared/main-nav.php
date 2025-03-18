<?php 

session_start();
$role = $_SESSION['role'];

?>

<nav class="navbar navbar-expand-sm bg-light mb-5">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Hola Hora</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Hola Hora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-start flex-grow-2 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../shared/dashboard.php">Dashboard</a>
          </li>
          
          <?php if ($role == 'A'): ?>
            <li class="nav-item">
              <a class="nav-link" href="../admin/team-management.php">Teams</a>
            </li>
          <?php elseif ($role == 'M'): ?>
            <li class="nav-item">
              <a class="nav-link" href="../manager/team-management.php">Employees</a>
            </li>
          <?php elseif ($role == 'E'): ?>
            <li class="nav-item">
              <a class="nav-link" href="../employee/activity.php">Activity Tracker</a>
            </li>
          <?php endif; ?>

          <?php if ($role != 'E'): ?>
            <li class="nav-item">
              <a class="nav-link" href="../shared/live-activity.php">Live Activity</a>
            </li>
          <?php endif; ?>
        </ul>
        
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"><?= $_SESSION['username']?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="../../actions/user/logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
