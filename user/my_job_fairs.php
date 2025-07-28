<?php
include '../db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header("Location: ../login.php");
  exit;
}

// Ambil data user untuk sidebar
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Ambil data job fairs yang diikuti user
$query = "SELECT r.id as registration_id, j.job_fair_name, j.gmeet_link, j.quota_remaining, j.short_desc
          FROM job_fair_registrations r
          JOIN job_fairs j ON r.job_fair_id = j.id
          WHERE r.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$job_fairs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Job Fairs - Upvoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
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

    <!-- Main Content -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-4">My Registered Job Fairs</h4>

        <?php if (count($job_fairs) > 0): ?>
          <div class="row g-3">
            <?php foreach ($job_fairs as $fair): ?>
              <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($fair['job_fair_name']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($fair['short_desc']) ?></p>
                    <p class="text-muted small">Quota Remaining: <?= $fair['quota_remaining'] ?></p>
                    <div class="d-flex justify-content-between">
                     <?php if (!empty($fair['gmeet_link'])): ?>
                        <a href="<?= htmlspecialchars($fair['gmeet_link']) ?>" target="_blank" class="btn btn-success btn-sm">
                            Join GMeet <i class="bi bi-camera-video ms-1"></i>
                        </a>
                        <?php else: ?>
                        <button class="btn btn-outline-secondary btn-sm" disabled title="GMeet belum diunggah oleh penyelenggara">
                            <i class="bi bi-camera-video-off me-1"></i> Not Uploaded
                        </button>
                        <?php endif; ?>

                      <form method="post" action="delete_registration.php" onsubmit="return confirm('Are you sure you want to cancel this registration?')">
                        <input type="hidden" name="registration_id" value="<?= $fair['registration_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="bi bi-trash"></i> Cancel
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-muted">You haven’t registered for any job fairs yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include '../assets/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
