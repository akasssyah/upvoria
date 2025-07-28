<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upvoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #8196DB;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .navbar .nav-link,
    .navbar .navbar-brand {
      color: white !important;
    }

    .navbar-toggler {
      background-color: white;
    }

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

   .footer-section {
    position: relative;
    background-color: #8196DB;
    color: white;
    padding: 60px 0 30px 0;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    overflow: hidden;
    margin-top: 100px;
   }

   .footer-section::before {
    content: "";
    position: absolute;
    top: -0px; /* naik sedikit ke atas */
    left: 0;
    width: 100%;
    height: 80px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 1), rgba(129, 150, 219, 0));
    z-index: 1;
   }

    @media (max-width: 768px) {
      .welcome {
        padding: 60px 20px;
        text-align: center;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="assets/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Job Fairs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>

        <ul class="navbar-nav align-items-center mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

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
    
    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="background-color: #E5F0E7;">
        <div class="card-body">
          <h5 class="card-title fw-bold text-secondary">2025 Job Fair</h5>
          <p class="card-text"><strong>Thursday, June 22nd<br>11:00 PM</strong></p>
          <p class="card-text small">Math, order, and structure. This job fair showcases companies looking for data scientists.</p>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="background-color: #FDEBED;">
        <div class="card-body">
          <h5 class="card-title fw-bold text-secondary">2025 Job Fair</h5>
          <p class="card-text"><strong>Friday, June 30th<br>10:00 AM</strong></p>
          <p class="card-text small">Interested in the culinary track? This job fair is all about the food and beverage business.</p>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="background-color: #FFF7D6;">
        <div class="card-body">
          <h5 class="card-title fw-bold text-secondary">2025 Job Fair</h5>
          <p class="card-text"><strong>Sunday, July 1st<br>08:00 AM</strong></p>
          <p class="card-text small">Interior designers are most welcome. A job fair for up and coming interior designers.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container my-5">
  <h5 class="text-center mb-4">Top companies we've worked with</h5>
  <div class="list-group">
    
    <!-- Company 1 -->
    <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded mb-3 border-0">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
          <img src="assets/company1-icon.svg" alt="Lumora" width="20" height="20" />
        </div>
        <strong>Lumora Tech Inc.</strong>
      </div>
      <div>
        <strong>389</strong> <small class="text-muted">hired</small>
      </div>
    </div>

    <!-- Company 2 -->
    <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded mb-3 border-0">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
          <img src="assets/company2-icon.svg" alt="Velora" width="20" height="20" />
        </div>
        <strong>Velora Foods</strong>
      </div>
      <div>
        <strong>263</strong> <small class="text-muted">hired</small>
      </div>
    </div>

    <!-- Company 3 -->
    <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded border-0">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
          <img src="assets/company3-icon.svg" alt="NexaSphere" width="20" height="20" />
        </div>
        <strong>NexaSphere</strong>
      </div>
      <div>
        <strong>218</strong> <small class="text-muted">hired</small>
      </div>
    </div>

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

<footer class="footer-section text-white pt-5 pb-3 position-relative" style="z-index: 2;">
  <div class="container">
    <div class="row justify-content-between align-items-start">
      
      <!-- Kiri: Logo dan Kontak -->
      <div class="col-md-6 mb-4">
        <img src="assets/logo.png" alt="Upvoria Logo" width="120" height="auto" class="mb-3">
        <p>101 Charming Avenue, Brooklyn, New<br>York State, United States of America</p>
        <p class="mb-1">Email: <a href="mailto:service@upvoria.com" class="text-white text-decoration-underline">service@upvoria.com</a></p>
        <p>Phone: 555-1239-1892</p>
      </div>

      <!-- Kanan: Sosial media dan copyright -->
      <div class="col-md-5 mb-4 text-md-end text-start d-flex flex-column justify-content-between">
        <div>
          <div class="mb-3">
            <a href="#" class="text-white me-3 fs-5"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-white fs-5"><i class="bi bi-linkedin"></i></a>
          </div>
          <p class="mb-0">
            <a href="#" class="text-white text-decoration-underline">Contact Us</a>
          </p>
        </div>
        <small class="mt-auto">Upvoria Virtual Job Fair © 2025 Copyright</small>
      </div>
    </div>
  </div>
</footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
