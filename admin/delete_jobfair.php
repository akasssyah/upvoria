<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
  $id = intval($_POST['id']);

  // Hapus data dari tabel child terlebih dahulu
  mysqli_query($conn, "DELETE FROM job_fair_companies WHERE job_fair_id = $id");

  // Baru hapus dari tabel parent
  $result = mysqli_query($conn, "DELETE FROM job_fairs WHERE id = $id");

  if ($result) {
    header("Location: jobfairs.php");
    exit;
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "Permintaan tidak valid.";
}
?>
