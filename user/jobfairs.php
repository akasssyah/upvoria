<?php
include '../db.php';
session_start();

$id = $_SESSION['user_id'] ?? null;
if (!$id) {
  header("Location: login.php");
  exit;
}

$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$colors = ['#E0F2FE', '#DCFCE7', '#FEF9C3', '#FCE7F3', '#EDE9FE', '#F3F4F6'];

// Pencarian
$search = $_GET['search'] ?? '';
$searchSql = $search ? "WHERE job_fair_name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR short_desc LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'" : '';

$currentDate = date('Y-m-d H:i:s');
$whereClause = $searchSql ? "$searchSql AND datetime >= '$currentDate'" : "WHERE datetime >= '$currentDate'";
$result = mysqli_query($conn, "SELECT * FROM job_fairs $whereClause ORDER BY datetime ASC");

$companies_by_fair = [];
$company_result = $conn->query("SELECT job_fair_id, company_name FROM job_fair_companies");

while ($row = $company_result->fetch_assoc()) {
    $companies_by_fair[$row['job_fair_id']][] = $row['company_name'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upvoria - Job Fairs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
  <style>
    .job-card {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      padding: 15px;
      height: 200px;
      cursor: pointer;
    }
    .job-card:hover {
      transform: scale(1.02);
      transition: 0.3s;
    }
  </style>
</head>
<body>
<?php include '../assets/navbar.php'; ?>

<div class="container py-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Here’s where it all starts..</h2>
    <p class="text-muted">Look up ongoing or incoming job fairs</p>

    <form method="GET" class="d-flex justify-content-center mt-3">
      <div class="input-group w-50">
        <input type="text" name="search" class="form-control rounded-start-pill px-4" placeholder="Search Job Fairs..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary rounded-end-pill px-4" type="submit">Search</button>
      </div>
    </form>
  </div>

  <div id="jobFairList" class="row g-4">
    <?php 
    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $bgColor = $colors[$index % count($colors)];
      $dateFormatted = date('l, F jS Y', strtotime($row['datetime']));
      $timeFormatted = date('g:i A', strtotime($row['datetime']));
    ?>
      <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
        <div class="job-card w-100" style="background-color: <?= $bgColor ?>;" onclick='openModal(<?= json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
          <h5 class="fw-bold"><?= htmlspecialchars($row['job_fair_name']) ?></h5>
          <p class="mb-2 text-muted">
            <i class="bi bi-calendar-event"></i> <?= $dateFormatted ?><br>
            <i class="bi bi-clock"></i> <?= $timeFormatted ?>
          </p>
          <p class="text-secondary"><?= nl2br(substr($row['short_desc'], 0, 100)) ?>...</p>
        </div>
      </div>
    <?php 
      $index++;
    } 
    ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="jobFairModal" tabindex="-1" aria-labelledby="jobFairModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-light text-black rounded-top">
        <h5 class="modal-title fw-semibold" id="jobFairModalLabel">Job Fair Detail</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body p-4">
        <div class="mb-3">
          <span class="badge bg-info text-dark mb-2">Event Overview</span>
          <p id="jobFairDesc" class="text-muted mb-0" style="white-space: pre-line; line-height: 1.6;"></p>
        </div>

        <hr>

        <div class="row mb-3">
          <div class="col-md-6 mb-3 mb-md-0">
            <div class="border rounded p-3 bg-light">
              <h6 class="text-primary fw-semibold"><i class="bi bi-calendar-event me-2"></i>Event Time</h6>
              <p id="jobFairTime" class="mb-0 text-muted small"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 bg-light">
              <h6 class="text-success fw-semibold"><i class="bi bi-people-fill me-2"></i>Quota Info</h6>
              <p id="jobFairQuota" class="mb-0 text-muted small"></p>
            </div>
          </div>
        </div>

        <hr>

        <div class="mb-2">
          <h6 class="text-dark fw-semibold mb-2"><i class="bi bi-building me-2"></i>Participating Companies</h6>
          <ul id="companyList" class="ps-3 list-unstyled small">
            <!-- companies will be appended here -->
          </ul>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button id="saveSpotBtn" class="btn btn-primary">Register</button>
      </div>
    </div>
  </div>
</div>


<?php include '../assets/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>

  const companiesByFair = <?= json_encode($companies_by_fair, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

  let currentFairId = null;

  function openModal(data) {
    currentFairId = data.id;

    const dateTime = new Date(data.datetime);
    const dateFormatted = dateTime.toLocaleDateString('en-US', {
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
    const timeFormatted = dateTime.toLocaleTimeString('en-US', {
      hour: '2-digit', minute: '2-digit'
    });

    document.getElementById('jobFairModalLabel').textContent = data.job_fair_name;
    document.getElementById('jobFairDesc').innerHTML = data.long_desc.replace(/\n/g, '<br>');
    document.getElementById('jobFairTime').textContent = `${dateFormatted}, ${timeFormatted}`;
    document.getElementById('jobFairQuota').textContent = `${data.quota_remaining} remaining out of ${data.quota_total}`;

    const modal = new bootstrap.Modal(document.getElementById('jobFairModal'));

    const companyList = document.getElementById('companyList');
    companyList.innerHTML = '';

    if (companiesByFair[data.id] && companiesByFair[data.id].length > 0) {
      companiesByFair[data.id].forEach(company => {
        const li = document.createElement('li');
        li.textContent = company;
        companyList.appendChild(li);
      });
    } else {
      const li = document.createElement('li');
      li.innerHTML = '<em>No companies listed yet.</em>';
      companyList.appendChild(li);
    }

    modal.show();
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveSpotBtn').addEventListener('click', () => {
      if (!currentFairId) return;

      fetch('save_spot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'job_fair_id=' + encodeURIComponent(currentFairId)
      })
      .then(res => res.text())
      .then(data => {
        alert(data);
        const modal = bootstrap.Modal.getInstance(document.getElementById('jobFairModal'));
        modal.hide();
      });
    });
  });
</script>
</body>
</html>
