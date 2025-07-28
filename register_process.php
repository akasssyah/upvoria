<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Validasi
  if ($password !== $confirmPassword) {
    die("Password dan konfirmasi tidak cocok.");
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $hashedPassword);

  if ($stmt->execute()) {
   // Di akhir file register_process.php
   header("Location: login.php?success=Registration successful. Please log in.");
   exit();

  } else {
    echo "Registrasi gagal: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>