<?php
include '../db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$job_fair_id = $_POST['job_fair_id'] ?? null;

if (!$user_id || !$job_fair_id) {
  http_response_code(400);
  echo "Missing user or fair ID.";
  exit;
}

// Cek apakah user sudah daftar
$check = $conn->prepare("SELECT id FROM job_fair_registrations WHERE user_id = ? AND job_fair_id = ?");
$check->bind_param("ii", $user_id, $job_fair_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
  echo "You have already registered.";
  exit;
}

// Cek quota remaining
$quotaCheck = $conn->prepare("SELECT quota_remaining FROM job_fairs WHERE id = ?");
$quotaCheck->bind_param("i", $job_fair_id);
$quotaCheck->execute();
$quotaResult = $quotaCheck->get_result();

if ($quotaRow = $quotaResult->fetch_assoc()) {
  if ($quotaRow['quota_remaining'] <= 0) {
    echo "Sorry, registration is full.";
    exit;
  }
} else {
  echo "Job fair not found.";
  exit;
}

// Ambil nama dan email user
$getUser = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$getUser->bind_param("i", $user_id);
$getUser->execute();
$userResult = $getUser->get_result();
if ($userRow = $userResult->fetch_assoc()) {
  $userString = $userRow['name'] . ' <' . $userRow['email'] . '>';
} else {
  echo "User not found.";
  exit;
}

// Simpan pendaftaran
$insert = $conn->prepare("INSERT INTO job_fair_registrations (user_id, job_fair_id) VALUES (?, ?)");
$insert->bind_param("ii", $user_id, $job_fair_id);

if ($insert->execute()) {
  // Ambil data nama dan email user
  $getUser = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
  $getUser->bind_param("i", $user_id);
  $getUser->execute();
  $userResult = $getUser->get_result();

  if ($userData = $userResult->fetch_assoc()) {
    $userString = $userData['name'] . ' (' . $userData['email'] . ')';

    // Update job_fairs
    $update = $conn->prepare("
      UPDATE job_fairs 
      SET 
        users_joined = CONCAT(CASE WHEN users_joined = '' THEN '' ELSE CONCAT(users_joined, ', ') END, ?),
        quota_remaining = quota_remaining - 1
      WHERE id = ? AND quota_remaining > 0
    ");
    $update->bind_param("si", $userString, $job_fair_id);

    if ($update->execute() && $update->affected_rows > 0) {
      echo "Successfully saved your spot!";
    } else {
      echo "Registration saved, but quota is full or update failed.";
    }
  } else {
    echo "User data not found.";
  }
} else {
  echo "Error occurred. Try again.";
}
