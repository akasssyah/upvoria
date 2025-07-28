<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login | Upvoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(to bottom, #8196DB 0%, #aabcf1 50%, #8196DB 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .logo {
      margin-bottom: 30px;
    }

    .login-card {
      background-color: white;
      border-radius: 15px;
      padding: 40px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .form-control:focus {
      border-color: #8196DB;
      box-shadow: 0 0 0 0.2rem rgba(129, 150, 219, 0.25);
    }

    .btn-primary {
      background-color: #3a4c97;
      border: none;
    }

    .btn-primary:hover {
      background-color: #2c3a79;
    }
  </style>
</head>
<body>

<!-- Logo -->
<img src="assets/logo.png" alt="Upvoria Logo" class="logo" width="100" />

<!-- Login Card -->
<div class="login-card text-center">
  <h5 class="fw-bold mb-4">Admin Login</h5>

  <?php if (isset($_GET['error'])): ?>
  <div class="alert alert-danger">
    <?= htmlspecialchars($_GET['error']) ?>
  </div>
  <?php endif; ?>

  <form method="POST" action="admin_login_process.php">
    <div class="mb-3 text-start">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin username" required>
    </div>
    <div class="mb-3 text-start">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
