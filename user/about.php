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
<style>
.container{
    margin-top : 80px;
}

.meet{
    margin-top : 70px
}

</style>
</head>
<body>
 <?php include '../assets/navbar.php'; ?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">About Upvoria</h2>
    <p class="mt-3 mx-auto" style="max-width: 800px;">
      <strong>Upvoria</strong> is a virtual job fair platform built to bridge the gap between top employers and ambitious job seekers through an interactive and accessible digital experience. We provide a centralized space where companies can set up virtual booths, host live sessions, and connect with candidates through real-time chat and video interviews — all without the limitations of physical location.
    </p>
  </div>

  <div class="mb-5">
    <p class="text-center mx-auto" style="max-width: 800px;">
      <strong>Designed for </strong>students, recent graduates, and professionals alike, Upvoria makes career exploration simple and engaging. Users can browse company profiles, attend webinars, drop resumes, and apply for jobs in just a few clicks. Meanwhile, recruiters can easily discover talent, manage applications, and streamline their hiring process using our integrated tools.
    </p>
  </div>

  <div class="mb-5">
    <p class="text-center mx-auto" style="max-width: 800px;">
      <strong>Our mission </strong>is to modernize the job fair experience by removing barriers and making opportunity available to everyone. Whether you're a job seeker or an employer, Upvoria empowers you to connect, grow, and thrive in the digital job market.
    </p>
  </div>

  <div class="text-center my-5">
    <h3 class="fw-bold meet">Meet the Team</h3>
  </div>

  <div class="row justify-content-center g-4">
    <!-- Team Member 1 -->
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm text-center border-0 rounded-4">
        <img src="https://i.ibb.co/6XfLkwF/profile1.png" class="card-img-top p-4" style="width: 150px; height: 150px; object-fit: contain; margin: auto;" alt="Yanto">
        <div class="card-body">
          <h5 class="card-title">Yanto/the Bocil</h5>
          <p class="card-text">Founder and CEO<br><small class="text-muted">Up since the offices set up</small></p>
          <a href="#" class="btn btn-outline-dark btn-sm rounded-pill"><i class="bi bi-linkedin"></i> LinkedIn</a>
        </div>
      </div>
    </div>

    <!-- Team Member 2 -->
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm text-center border-0 rounded-4">
        <img src="https://i.ibb.co/Xsfh5Mn/profile2.png" class="card-img-top p-4" style="width: 150px; height: 150px; object-fit: contain; margin: auto;" alt="Vivi">
        <div class="card-body">
          <h5 class="card-title">Vivi A.S.N.</h5>
          <p class="card-text">Fullstack Developer<br><small class="text-muted">Hasn't slept in 2 months</small></p>
          <a href="#" class="btn btn-outline-dark btn-sm rounded-pill"><i class="bi bi-linkedin"></i> LinkedIn</a>
        </div>
      </div>
    </div>

    <!-- Team Member 3 -->
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm text-center border-0 rounded-4">
        <img src="https://i.ibb.co/Z8MQCbf/profile3.png" class="card-img-top p-4" style="width: 150px; height: 150px; object-fit: contain; margin: auto;" alt="Eko">
        <div class="card-body">
          <h5 class="card-title">(Aa) Eko</h5>
          <p class="card-text">Head of Finance Department<br><small class="text-muted">Tries to forget where he puts his ID</small></p>
          <a href="#" class="btn btn-outline-dark btn-sm rounded-pill"><i class="bi bi-linkedin"></i> LinkedIn</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../assets/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>