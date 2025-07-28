<?php
include '../db.php'; // koneksi database

session_start(); // penting jika belum dipanggil

$id = $_SESSION['user_id'] ?? null;

if (!$id) {
  // Jika belum login, redirect
  header("Location: login.php");
  exit;
}

$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id); // "i" karena id berupa integer
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Upvoria</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">

<style></style>

</head>
<body>
 <?php include '../assets/navbar.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <!-- Sidebar -->
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm rounded-4 p-3">
        <div class="text-center mb-3">
          <i class="bi bi-person-circle fs-1"></i>
          <h6 class="mt-2 mb-0 fw-semibold"><?= htmlspecialchars($user['name']) ?></h6>
        </div>
        <ul class="list-group list-group-flush">
          <a href="profile.php" class="list-group-item d-flex justify-content-between align-items-center border-0 text-decoration-none text-dark">
            <div><i class="bi bi-person me-2"></i> My Profile</div>
            <i class="bi bi-chevron-right"></i>
          </a>
          <a href="my_job_fairs.php" class="list-group-item d-flex justify-content-between align-items-center border-0 text-decoration-none text-dark">
            <div><i class="bi bi-briefcase me-2"></i> My Job Fairs</div>
            <i class="bi bi-chevron-right"></i>
          </a>
          <a href="../logout.php" class="list-group-item d-flex justify-content-between align-items-center border-0 text-decoration-none text-dark">
            <div><i class="bi bi-box-arrow-right me-2"></i> Log Out</div>
          </a>
        </ul>
      </div>
    </div>


    <!-- Profile Form -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-center mb-3">
          <i class="bi bi-person-circle fs-1 me-3"></i>
          <div>
            <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($user['name']) ?></h6>
            <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
          </div>
        </div>
<form>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" readonly>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
  </div>
</form>

      </div>
    </div>
  </div>
</div>


<?php include '../assets/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>