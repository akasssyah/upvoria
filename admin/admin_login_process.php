<?php
session_start();

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: admin-login.php");
  exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'admin' && $password === '1234') {
    $_SESSION['admin'] = $username;
    header("Location: index.php");
    exit;
} else {
    header("Location: admin-login.php?error=Invalid credentials");
    exit;
}
?>
