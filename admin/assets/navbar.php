<div class="col-md-2 sidebar p-3">
  <h4 class="text-primary fw-bold mb-4">Admin</h4>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link active d-flex align-items-center" href="index.php">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    <li class="nav-item mt-2">
      <span class="text-muted small">User</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="data-user.php"><i class="bi bi-stack me-2"></i> Data User</a>
    </li>

    <li class="nav-item mt-2">
      <span class="text-muted small">Companies</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="data-companies.php"><i class="bi bi-stack me-2"></i> Data Companies</a>
    </li>

    <li class="nav-item mt-2">
      <span class="text-muted small">Job Fairs</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="jobfairs.php"><i class="bi bi-ui-checks me-2"></i> Job Fairs</a>
    </li>
<li class="nav-item mt-4">
  <form action="admin_login_process.php" method="POST">
    <button type="submit" name="logout" class="btn btn-outline-danger w-100">
      <i class="bi bi-box-arrow-right me-2"></i> Logout
    </button>
  </form>
</li>

  </ul>
  
</div>
