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


$search = $_GET['search'] ?? '';
$searchSql = $search ? "WHERE name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'" : '';

$query = "SELECT * FROM company $searchSql ORDER BY name ASC";
$result = mysqli_query($conn, $query);
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
<style>
.container{
    margin-top : 80px;
}

 .card {
    min-height: 165px;
  }

  .company-logo {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}
</style>
</head>
<body>
 <?php include '../assets/navbar.php'; ?>

<div class="container my-5 top">
  <!-- Title Section -->
  <h2 class="text-center fw-bold">Get to know your future employers!</h2>
  <p class="text-center text-muted">Look up companies we work with</p>

  <!-- Search -->
  <div class="d-flex justify-content-center my-4">
    <form method="GET" class="w-50">
      <div class="input-group">
        <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Search companies..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary rounded-end-pill" type="submit">Search</button>
      </div>
    </form>
  </div>

  <!-- Company Cards -->
  <div class="row g-3">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($company = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4 p-3">
          <div class="d-flex align-items-center">
            <!-- Logo -->
            <?php 
              $logo = isset($company['logo']) ? htmlspecialchars($company['logo'], ENT_QUOTES) : 'default.png';
              $logoPath = '../admin/' . $logo;
            ?>
            <?php if (!empty($company['logo']) && file_exists($logoPath)): ?>
              <img src="<?= $logoPath ?>" alt="Logo" class="company-logo me-3">
            <?php else: ?>
              <div class="company-logo me-3 d-flex align-items-center justify-content-center bg-light text-muted">
                <span>N/A</span>
              </div>
            <?php endif; ?>

            <!-- Info -->
            <div class="flex-grow-1">
              <h6 class="mb-0 fw-bold"><?= htmlspecialchars($company['name']) ?></h6>
              <small class="text-muted"><?= htmlspecialchars($company['category'] ?? 'General') ?></small>
              <p class="text-muted mt-2 mb-0 small" style="font-size: 0.85em;">
                <?= htmlspecialchars($company['description'] ?? 'No description available.') ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-center text-muted">No companies found.</p>
  <?php endif; ?>
</div>


  <!-- Pagination Static -->
  <nav class="d-flex justify-content-center mt-4">
    <ul class="pagination">
      <li class="page-item disabled"><a class="page-link" href="#">&lt;</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">...</a></li>
      <li class="page-item"><a class="page-link" href="#">10</a></li>
      <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
    </ul>
  </nav>
</div>

<?php include '../assets/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>