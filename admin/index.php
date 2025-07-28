<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

$companiesCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM company");
$companies = mysqli_fetch_assoc($companiesCount)['total'];

$jobFairsCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM job_fairs");
$jobFairs = mysqli_fetch_assoc($jobFairsCount)['total'];

$usersCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$users = mysqli_fetch_assoc($usersCount)['total'];

$registrationsQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) AS total FROM job_fair_registrations");
$totalRegisteredUsers = mysqli_fetch_assoc($registrationsQuery)['total'];

// 2 job fair terbaru
$latestJobFairsQuery = mysqli_query($conn, "SELECT job_fair_name, datetime FROM job_fairs ORDER BY datetime DESC LIMIT 2");
$latestJobFairs = [];
while ($row = mysqli_fetch_assoc($latestJobFairsQuery)) {
  $latestJobFairs[] = $row;
}

// Query jumlah user gabung job fair per hari
$userJoinedPerDayQuery = mysqli_query($conn, "
  SELECT DATE(datetime) AS date, SUM(users_joined) AS total
  FROM job_fairs
  GROUP BY DATE(datetime)
  ORDER BY date ASC
");
$chartLabels = [];
$chartData = [];
while ($row = mysqli_fetch_assoc($userJoinedPerDayQuery)) {
  $chartLabels[] = $row['date'];
  $chartData[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="assets/styles.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container-fluid">
  <div class="row">
     <!-- Sidebar -->
     <?php include('assets/navbar.php'); ?>
    <!-- Content -->
    <div class="col-md-10 p-4">
      <h5 class="fw-bold mb-4">Profile Statistics</h5>

      <!-- Stats -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="stat-card shadow-sm">
            <h6>Companies</h6>
            <h3><?= number_format($companies) ?></h3>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card shadow-sm">
            <h6>Job Fairs</h6>
            <h3><?= number_format($jobFairs) ?></h3>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card shadow-sm">
            <h6>User</h6>
            <h3><?= number_format($users) ?></h3>
          </div>
        </div>
      </div>

      <!-- Chart -->
      <div class="row">
        <div class="col-md-8">
          <div class="card p-3 shadow-sm rounded-4">
            <h6 class="fw-semibold mb-3">User Joined Job Fair per Day</h6>
            <canvas id="userChart" height="130"></canvas>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-3 mb-3 shadow-sm rounded-4">
            <h6 class="fw-semibold">User Registered Fairs</h6>
            <p>Total: <?= number_format($totalRegisteredUsers) ?> users</p>
          </div>

          <div class="card p-3 shadow-sm rounded-4">
            <h6 class="fw-semibold">Latest Job Fairs</h6>
            <?php foreach ($latestJobFairs as $fair): ?>
              <p><i class="bi bi-briefcase-fill me-2"></i> <?= $fair['job_fair_name'] ?> (<?= date('d M Y', strtotime($fair['datetime'])) ?>)</p>
            <?php endforeach; ?>
          </div>
        </div>  
    </div>
  </div>
</div>

<!-- Chart Script -->
<script>
const ctx = document.getElementById('userChart').getContext('2d');
const userChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{
      label: 'Users Joined',
      data: <?= json_encode($chartData) ?>,
      fill: true,
      backgroundColor: 'rgba(78, 115, 223, 0.1)',
      borderColor: 'rgba(78, 115, 223, 1)',
      borderWidth: 2,
      tension: 0.3,
      pointRadius: 3,
      pointBackgroundColor: 'rgba(78, 115, 223, 1)',
      pointBorderColor: '#fff'
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
});
</script>

</body>
</html>
