<?php
session_start();
require_once '../db.php'; // koneksi ke database

if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

// Ambil semua job fair
$result = mysqli_query($conn, "SELECT * FROM job_fairs ORDER BY datetime DESC");

// Ambil data companies
$company_result = mysqli_query($conn, "SELECT * FROM company");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Job Fairs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="assets/styles.css" rel="stylesheet"/>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <?php include('assets/navbar.php'); ?>
    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Job Fairs</h4>
        <button class="btn btn-success rounded-3" data-bs-toggle="modal" data-bs-target="#addJobFairModal">
          <i class="bi bi-plus-circle"></i> Add Job Fair
        </button>
      </div>

      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <table class="table table-bordered align-middle table-hover">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Job Fair</th>
                <th>Short Desc</th>
                <th>Long Desc</th>
                <th>Date & Time</th>
                <th>Users Joined</th>
                <th>Remaining Quota</th>
                <th>GMeet Link</th>
                <th>Actions</th>
              </tr>
            </thead>
<tbody>
<?php
  $no = 1;
  while ($row = mysqli_fetch_assoc($result)) {
    $escapedDesc = htmlspecialchars($row['long_desc'], ENT_QUOTES);
    $escapedUsers = $row['users_joined'];
    
    $quotaTotal = (int) $row['quota_total'];
    $quotaRemaining = (int) $row['quota_remaining'];
    $quotaJoined = $quotaTotal - $quotaRemaining;

    echo "<tr>
            <td>{$no}</td>
            <td>{$row['job_fair_name']}</td>
            <td>{$row['short_desc']}</td>
            <td>" . substr($row['long_desc'], 0, 40) . "... 
              <a href='#' onclick=\"showDesc('{$escapedDesc}')\" data-bs-toggle='modal' data-bs-target='#descModal'>Read more</a>
            </td>
            <td>" . date('d M Y H:i', strtotime($row['datetime'])) . "</td>
            <td>
              {$row['users_joined']} 
              <a href='#' class='d-block small' onclick=\"showUsers('{$escapedUsers}')\" data-bs-toggle='modal' data-bs-target='#usersModal'>View all</a>
            </td>
            <td>{$quotaJoined} / {$quotaTotal}</td>
            <td id='gmeet-{$row['id']}' data-link='{$row['gmeet_link']}'>";
              echo $row['gmeet_link'] ? "<a href='{$row['gmeet_link']}' target='_blank'>GMeet</a>" : "-";
    echo   "</td>
            <td>
              <button class='btn btn-sm btn-success mb-1' onclick=\"editGmeet('{$row['id']}')\">
                <i class='bi bi-link-45deg'></i>
              </button>
              <button class='btn btn-sm btn-warning' onclick='editJobFair(" . json_encode($row) . ")'>
                <i class='bi bi-pencil-square'></i>
              </button>
              <button class='btn btn-sm btn-danger' onclick='confirmDelete({$row['id']})'>
                <i class='bi bi-trash'></i>
              </button>
            </td>
          </tr>";
    $no++;
  }
?>

</tbody>


          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Add Job Fair Modal -->
<div class="modal fade" id="addJobFairModal" tabindex="-1" aria-labelledby="addJobFairModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4">
      <form action="process.php" method="POST">
        <input type="hidden" name="action" value="add_jobfair">
        <div class="modal-header">
          <h5 class="modal-title" id="addJobFairModalLabel">Add Job Fair</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Job Fair Name</label>
            <input type="text" name="job_fair_name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date & Time</label>
            <input type="datetime-local" name="datetime" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Short Description</label>
            <input type="text" name="short_desc" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Long Description</label>
            <textarea name="long_desc" class="form-control" rows="4" required></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kuota Peserta</label>
            <input type="number" name="quota_total" class="form-control" min="1" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">GMeet Link (Opsional)</label>
            <input type="url" name="gmeet_link" class="form-control" placeholder="https://meet.google.com/abc-defg-hij">
          </div>
        <div class="col-md-12">
          <label class="form-label">Company</label>
          <div class="row">
             <?php while ($company = mysqli_fetch_assoc($company_result)) : ?>
             <div class="col-md-6">
             <div class="form-check">
              <input class="form-check-input" type="checkbox" name="company_names[]" value="<?= $company['name']; ?>" id="company-<?= $company['id']; ?>">
              <label class="form-check-label" for="company-<?= $company['id']; ?>">
               <?= $company['name']; ?>
              </label>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-success rounded-3">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit GMeet -->
<div class="modal fade" id="editGmeetModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="process.php">
      <input type="hidden" name="action" value="edit_gmeet">
      <input type="hidden" name="id" id="editGmeetId">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit GMeet Link</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="gmeetLink" class="form-label">GMeet Link</label>
            <input type="text" name="gmeet_link" id="gmeetLink" class="form-control" placeholder="https://meet.google.com/...">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Job Fair -->
<div class="modal fade" id="editJobFairModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="process.php">
      <input type="hidden" name="action" value="edit_jobfair">
      <input type="hidden" name="id" id="editId">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title">Edit Job Fair</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Job Fair Name</label>
            <input type="text" name="job_fair_name" id="editName" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date & Time</label>
            <input type="datetime-local" name="datetime" id="editDatetime" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Short Description</label>
            <input type="text" name="short_desc" id="editShort" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Long Description</label>
            <textarea name="long_desc" id="editLong" class="form-control" rows="4" required></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kuota Peserta</label>
            <input type="number" name="quota_total" id="editQuota" class="form-control" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">GMeet Link</label>
            <input type="url" name="gmeet_link" id="editGmeet" class="form-control">
          </div>
          <!-- Tambah jika perlu: Select Company -->
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-warning">Save Changes</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal for Long Description -->
<div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Full Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="descContent"></div>
    </div>
  </div>
</div>

<!-- Modal for Users Joined -->
<div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="usersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Users Joined</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="usersContent"></div>
    </div>
  </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="delete_jobfair.php">
      <input type="hidden" name="action" value="delete_jobfair">
      <input type="hidden" name="id" id="deleteJobFairId">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Delete Job Fair</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this job fair?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script>
  function editGmeet(id) {
    document.getElementById('editGmeetId').value = id;
    var currentLink = document.querySelector(`#gmeet-${id}`).dataset.link;
    document.getElementById('gmeetLink').value = currentLink;
    new bootstrap.Modal(document.getElementById('editGmeetModal')).show();
  }

  function editUsers(id) {
    document.getElementById('editUsersId').value = id;
    var currentUsers = document.querySelector(`#users-${id}`).dataset.users;
    document.getElementById('usersJoined').value = currentUsers;
    new bootstrap.Modal(document.getElementById('editUsersModal')).show();
  }

  function showDesc(desc) {
  document.getElementById('descContent').textContent = desc;
  }

  function showUsers(users) {
  if (!users) {
    document.getElementById('usersContent').innerHTML = "<em>No users joined yet.</em>";
    return;
  }

  const userList = users.split(',').map(name => name.trim());
  const formattedList = "<ul class='list-group'>" + 
    userList.map(user => `<li class='list-group-item'>${user}</li>`).join('') + 
    "</ul>";

  document.getElementById('usersContent').innerHTML = formattedList;
}

  function editJobFair(data) {
  document.getElementById('editId').value = data.id;
  document.getElementById('editName').value = data.job_fair_name;
  document.getElementById('editShort').value = data.short_desc;
  document.getElementById('editLong').value = data.long_desc;
  document.getElementById('editQuota').value = data.quota_total;
  document.getElementById('editGmeet').value = data.gmeet_link;

  // Convert datetime to input format
  let dt = new Date(data.datetime);
  document.getElementById('editDatetime').value = dt.toISOString().slice(0, 16);

  new bootstrap.Modal(document.getElementById('editJobFairModal')).show();
}

</script>

<script>
    function confirmDelete(id) {
      document.getElementById('deleteJobFairId').value = id;
      new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>

</body>
</html>
