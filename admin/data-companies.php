<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}
require_once '../db.php';

$result = mysqli_query($conn, "SELECT * FROM company");
$companies = [];
if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $companies[] = $row;
  }
}

$categories = [
  "Information Technology", "Healthcare", "Education", "Food", "Finance",
  "Manufacturing", "Retail", "Construction", "Tourism", "Transportation",
  "Government", "Media", "Agriculture", "Other"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Data Company</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="assets/styles.css" rel="stylesheet"/>
  <style>
    .company-logo {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <?php include('assets/navbar.php'); ?>

    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Data Company</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          <i class="bi bi-plus-lg"></i> Tambah Company
        </button>
      </div>

      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Logo</th>
                <th>Nama Company</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th style="width: 140px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($companies as $index => $company): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><img src="<?= $company['logo'] ?>" class="company-logo" alt="Logo"></td>
                <td><?= htmlspecialchars($company['name']) ?></td>
                <td><?= htmlspecialchars($company['category']) ?></td>
                <td><?= strlen($company['description']) > 50 ? substr($company['description'], 0, 50) . '...' : $company['description'] ?></td>
                <td>
                  <!-- Button Edit Modal -->
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $company['id'] ?>">
                    <i class="bi bi-pencil-fill"></i>
                  </button>

                  <!-- Button Delete -->
                  <form action="process.php" method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $company['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </form>
                </td>
              </tr>

              <!-- Modal Edit -->
              <div class="modal fade" id="editModal<?= $company['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content rounded-4">
                    <form action="process.php" method="POST" enctype="multipart/form-data">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Company</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $company['id'] ?>">

                        <div class="mb-3">
                          <label>Nama Perusahaan</label>
                          <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($company['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                          <label>Kategori</label>
                          <select class="form-select" name="category" required>
                            <option value="">-- Select Category --</option>
                            <?php
                             $selectedCategory = isset($company['category']) ? $company['category'] : '';
                            foreach ($categories as $cat) {
                              $selected = $cat == $company['category'] ? "selected" : "";
                              echo "<option value=\"$cat\" $selected>$cat</option>";
                            }
                            ?>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($company['description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                          <label>Ganti Logo (opsional)</label>
                          <input type="file" class="form-control" name="logo" accept="image/*">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="update_company" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <form action="process.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Company</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label>Kategori</label>
            <select class="form-select" name="category" required>
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>"><?= $cat ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea class="form-control" rows="3" name="description" required></textarea>
          </div>
          <div class="mb-3">
            <label>Upload Logo</label>
            <input type="file" class="form-control" name="logo" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_company" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
