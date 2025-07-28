<?php
include '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

  
  $sql = "SELECT * FROM job_fairs WHERE datetime >= NOW() ORDER BY datetime ASC LIMIT 3";
  $result = $conn->query($sql);

  $job_fairs = [];

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $job_fairs[] = $row;
      }
  }

  function getCardColor($id) {
  $colors = ['#E5F0E7', '#FDEBED', '#FFF7D6'];
  return $colors[$id % count($colors)];
  }

  function formatDateTime($datetime) {
    $dt = new DateTime($datetime);
    return $dt->format('l, F jS') . "<br>" . $dt->format('h:i A');
  }

  $sql = "SELECT * FROM company ORDER BY id ASC LIMIT 3";
  $result = $conn->query($sql);

  $companies = [];

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $companies[] = $row;
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upvoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">

  <style>
    .welcome {
      position: relative;
      background-color: #8196DB;
      color: #fff;
      padding: 80px 50px;
      text-align: left;
      overflow: visible;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      z-index: 1;
    }

    .welcome::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      height: 150px;
      background: linear-gradient(to bottom, #8196DB, rgba(129, 150, 219, 0));
      z-index: -1;
    }

    .event{
        margin-top: 200px;
    }

   .intro-section {
    background: linear-gradient(
    to bottom,
    rgba(129, 150, 219, 0) 0%,
    rgba(129, 150, 219, 1) 20%,
    rgba(129, 150, 219, 1) 80%,
    rgba(129, 150, 219, 0) 100%
    );

    margin-top: 200px;
    margin-bottom: 200px;
    }
    
  </style>
</head>

<body>
<?php include '../assets/navbar.php'; ?>

  <div class="welcome">
    <h1>Welcome to Upvoria!</h1>
    <p>
      Are you ready to jumpstart your career? Here at Upvoria, we try our best to make it as 
     <br>easy as possible to get your dream job and start the career you’ve dreamed of your whole life!
    </p>
  </div>

<div class="container my-5">
  <h4 class="text-center mb-4 event">Check out upcoming events</h4>
  <div class="row justify-content-center g-4">

    <?php foreach ($job_fairs as $fair): ?>
      <div class="col-md-4">
        <a href="jobfairs.php?id=<?= $fair['id'] ?>" style="text-decoration: none; color: inherit;">
          <div class="card shadow-sm border-0 h-100" style="background-color: <?= getCardColor($fair['id']) ?>;">
            <div class="card-body">
              <h5 class="card-title fw-bold text-secondary"><?= htmlspecialchars($fair['job_fair_name']) ?></h5>

              <p class="card-text fw-semibold">
                <?= formatDateTime($fair['datetime']) ?>
              </p>

              <p class="card-text small"><?= htmlspecialchars($fair['short_desc']) ?></p>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>

  </div>
</div>


<div class="container my-5">
  <h5 class="text-center mb-4">Top companies we've worked with</h5>
  <div class="list-group">
    <?php
    $hired_numbers = [389, 263, 218];
    foreach ($companies as $index => $company):
    ?>
    <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded mb-3 border-0">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
          <img src="../admin/<?= htmlspecialchars($company['logo']) ?>" alt="<?= htmlspecialchars($company['name']) ?>" width="20" height="20" />
        </div>
        <strong><?= htmlspecialchars($company['name']) ?></strong>
      </div>
      <div>
        <strong><?= $hired_numbers[$index] ?></strong> <small class="text-muted">hired</small>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>



<div class="intro-section text-white py-5 ">
  <div class="container">
    <div class="row mb-4">
      <div class="col-lg-12 text-lg-end text-center">
        <h3 class="fw-bold">Intro to Upvoria</h3>
        <p class="mb-1">
          We are a business whose main goal is to bring job opportunities to people who need them, and making the process even more accessible while achieving it.
          We really hope our platform could change many people’s lives.
          Be a part of our wonderful and fun journey. Register and join a job fair today.
        </p>
        <p class="fw-semibold">We will see you on top of your career ladder!</p>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <h4 class="fw-bold">Why Upvoria?</h4>
        <p>
          We know that job searching can be an exhausting and daunting task but through our platform, it could be easier.
          There’s no more need to attend crowded job fairs when you can attend one virtually!
          With our services, you can stand out amongst other candidates in the sea of unemployment. Easy access, easy hire!
        </p>
        <p class="fw-bold">Happy Hunting! Job Hunting, that is.</p>
      </div>
    </div>
  </div>
</div>



<div class="container my-5">
  <h5 class="text-center fw-bold mb-4">Hear what they had to say!</h5>
  <div class="row justify-content-center g-4">
    
    <!-- Testimonial 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm border rounded">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="me-2"><strong>🧑‍🍼 Hailey Dunphy</strong></div>
          </div>
          <div class="mb-2 text-warning">
            ★★★★★
          </div>
          <p class="card-text small text-muted">
            Dylan said I should get a job, but I DO have twin babies to take care of... whatever, I got one anyway...
          </p>
        </div>
      </div>
    </div>

    <!-- Testimonial 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm border rounded">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="me-2"><strong>🎓 Bellamy Blake</strong></div>
          </div>
          <div class="mb-2 text-warning">
            ★★★★★
          </div>
          <p class="card-text small text-muted">
            Great site. I got a job after going to a couple of these fairs. Now if only I could get my philosophy major friend a job...
          </p>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm border rounded">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="me-2"><strong>👩 Penny Hofstadter</strong></div>
          </div>
          <div class="mb-2 text-warning">
            ★★★★★
          </div>
          <p class="card-text small text-muted">
            My friend Amy signed me up for this site. She thought it was a dating website. *sigh*
          </p>
        </div>
      </div>
    </div>

  </div>

  <p class="text-center mt-4 fw-semibold">and so many more..</p>

  <div class="text-center mt-5">
    <h5 class="fw-bold mb-3">What could you possibly be waiting for?!</h5>
    <a href="#" class="btn btn-outline-dark">Join Now <span class="ms-1">➜</span></a>
  </div>
</div>

<?php include '../assets/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
