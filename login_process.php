<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usernameOrEmail = trim($_POST['name']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE name = ? OR email = ?");
  $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      header("Location: user/index.php");
      exit();
    } else {
      echo "Password salah.";
    }
  } else {
    header("Location: login.php?error=User tidak ditemukan.");
    exit();
  }

  $stmt->close();
  $conn->close();
}
?>
