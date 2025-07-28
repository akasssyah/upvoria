<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

require_once '../db.php';
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['delete_user']) && isset($_POST['id'])) {
  $id = $_POST['id'];
  $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  header("Location: data-user.php");
  exit;
}

function uploadLogo($file) {
  if ($file['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'uploads/' . uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], $filename);
    return $filename;
  }
  return null;
}

// Tambah Company
if (isset($_POST['add_company'])) {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $logoPath = uploadLogo($_FILES['logo']);

  $query = "INSERT INTO company (name, category, description, logo) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssss", $name, $category, $description, $logoPath);
  mysqli_stmt_execute($stmt);

  header("Location: data-companies.php");
  exit;
}

// Edit Company
if (isset($_POST['update_company'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $logoPath = uploadLogo($_FILES['logo']);

  if ($logoPath) {
    $query = "UPDATE company SET name=?, category=?, description=?, logo=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $category, $description, $logoPath, $id);
  } else {
    $query = "UPDATE company SET name=?, category=?, description=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $category, $description, $id);
  }

  mysqli_stmt_execute($stmt);
  header("Location: data-companies.php");
  exit;
}

// Hapus Company
if (isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];
  $query = "DELETE FROM company WHERE id=?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  header("Location: data-companies.php");
  exit;
}


$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add_jobfair') {
  // Tambah data job fair
$name = $_POST['job_fair_name'];
$short = $_POST['short_desc'];
$long = $_POST['long_desc'];
$datetime = $_POST['datetime'];
$quota = intval($_POST['quota_total']);
$gmeet = $_POST['gmeet_link'] ?? '';
$quota_remaining = $quota;

$stmt = $conn->prepare("INSERT INTO job_fairs (job_fair_name, short_desc, long_desc, datetime, quota_total, quota_remaining, gmeet_link)
  VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiis", $name, $short, $long, $datetime, $quota, $quota_remaining, $gmeet);
$stmt->execute();

// Ambil ID job fair yang baru ditambahkan
$job_fair_id = $stmt->insert_id;

$company_names = $_POST['company_names']; // ini array

$stmt_company = $conn->prepare("INSERT INTO job_fair_companies (job_fair_id, company_name) VALUES (?, ?)");

foreach ($company_names as $company_name) {
  $stmt_company->bind_param("is", $job_fair_id, $company_name);
  $stmt_company->execute();
}

  header("Location: jobfairs.php");
  exit;

} elseif ($action === 'update_gmeet') {
  // Update GMeet link
  $id = $_GET['id'];
  $link = $_GET['link'];

  $stmt = $conn->prepare("UPDATE job_fairs SET gmeet_link = ? WHERE id = ?");
  $stmt->bind_param("si", $link, $id);
  $stmt->execute();

  header("Location: jobfairs.php");
  exit;

} elseif ($action === 'edit_jobfair') {
  // Edit job fair
  $id = $_POST['id'];
  $name = $_POST['job_fair_name'];
  $short = $_POST['short_desc'];
  $long = $_POST['long_desc'];
  $datetime = $_POST['datetime'];
  $quota = intval($_POST['quota_total']);
  $gmeet = $_POST['gmeet_link'] ?? '';

  // Hitung ulang sisa kuota (opsional, tergantung logika kamu)
  $stmt = $conn->prepare("UPDATE job_fairs 
    SET job_fair_name=?, short_desc=?, long_desc=?, datetime=?, quota_total=?, gmeet_link=?
    WHERE id=?");
  $stmt->bind_param("ssssiii", $name, $short, $long, $datetime, $quota, $gmeet, $id);
  $stmt->execute();

  header("Location: jobfairs.php");
  exit;

} elseif ($action === 'delete_jobfair') {
  // Hapus job fair
  $id = $_GET['id'];
  $stmt = $conn->prepare("DELETE FROM job_fairs WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header("Location: jobfairs.php");
  exit;
}

// Update GMeet link
if (isset($_GET['action']) && $_GET['action'] === 'update_gmeet') {
    $id = (int) $_GET['id'];
    $link = clean_input($_GET['link']);

    $update = mysqli_query($conn, "UPDATE job_fairs SET gmeet_link='$link' WHERE id=$id");

    if ($update) {
        $_SESSION['success'] = "GMeet link updated.";
    } else {
        $_SESSION['error'] = "Failed to update GMeet link.";
    }

    header("Location: jobfairs.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require '../db.php'; // koneksi database

  if ($_POST['action'] === 'edit_gmeet') {
    $id = intval($_POST['id']);
    $link = $_POST['gmeet_link'];

    $stmt = $conn->prepare("UPDATE job_fairs SET gmeet_link = ? WHERE id = ?");
    $stmt->bind_param("si", $link, $id);
    $stmt->execute();

    header("Location: jobfairs.php");
    exit;
  }

  if ($_POST['action'] === 'edit_jobfair') {
    $id = intval($_POST['id']);
    $name = $_POST['job_fair_name'];
    $short = $_POST['short_desc'];
    $long = $_POST['long_desc'];
    $datetime = $_POST['datetime'];
    $quota = intval($_POST['quota_total']);

    $gmeet = !empty($_POST['gmeet_link']) ? $_POST['gmeet_link'] : null;

    $stmt = $conn->prepare("UPDATE job_fairs SET job_fair_name=?, short_desc=?, long_desc=?, datetime=?, quota_total=?, gmeet_link=? WHERE id=?");
    if (!$stmt) {
      die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssisi", $name, $short, $long, $datetime, $quota, $gmeet, $id);
    if (!$stmt->execute()) {
      die("Execute failed: " . $stmt->error);
    }

    header("Location: admin-jobfairs.php");
    exit;
  }
}

if ($_POST['action'] === 'delete_jobfair') {
  $id = intval($_POST['id']);
  $stmt = $conn->prepare("DELETE FROM job_fairs WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header("Location: index.php");
  exit;
}




?>

