  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="../assets/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../user/jobfairs.php">Job Fairs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../user/company.php">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../user/about.php">About</a>
          </li>
        </ul>

<ul class="navbar-nav align-items-center ms-auto">
  <li class="nav-item d-flex align-items-center gap-2">
    <a href="profile.php" class="nav-link d-flex align-items-center gap-2 text-white">
      <span>Hello, <?= $_SESSION['name'] ?? 'User' ?></span>
      <i class="bi bi-person-circle fs-5"></i>
    </a>
  </li>
</ul>


      </div>
    </div>
  </nav>