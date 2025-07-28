<?php
include '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration_id'])) {
    $registration_id = $_POST['registration_id'];

    // Cek user dan job fair ID
    $check = $conn->prepare("SELECT job_fair_id FROM job_fair_registrations WHERE id = ? AND user_id = ?");
    $check->bind_param("ii", $registration_id, $_SESSION['user_id']);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        header("Location: my_job_fairs.php?error=unauthorized");
        exit;
    }

    $row = $result->fetch_assoc();
    $job_fair_id = $row['job_fair_id'];

    $conn->begin_transaction();
    try {
        // Hapus dari registrations
        $delete = $conn->prepare("DELETE FROM job_fair_registrations WHERE id = ?");
        $delete->bind_param("i", $registration_id);
        $delete->execute();

        // Tambah quota remaining
        $updateQuota = $conn->prepare("UPDATE job_fairs SET quota_remaining = quota_remaining + 1 WHERE id = ?");
        $updateQuota->bind_param("i", $job_fair_id);
        $updateQuota->execute();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
    }
}

header("Location: my_job_fairs.php");
exit;
