<?php
session_start();

if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

require '../db.php';

$users = [];
$query = "SELECT id, name, email FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Data User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="assets/styles.css" rel="stylesheet"/>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include('assets/navbar.php'); ?>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h4 class="fw-bold mb-4">Data User</h4>

      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Username</th>
                <th>Email</th>
                <th style="width: 120px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($users) > 0): ?>
                <?php foreach ($users as $i => $user): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                      <form action="process.php?delete_user=1" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                          <i class="bi bi-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center">Tidak ada data user.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
