<?php
require 'function.php';
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header('Location: index.php');
  exit;
}

// Konfigurasi database
$host = 'localhost';
$dbname = 'rekam_medis';
$dbuser = 'root';
$dbpass = '';

// Membuat koneksi ke database
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Pastikan koneksi berhasil
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Tangani permintaan "get" untuk mendapatkan data dokter
if (isset($_GET['action']) && $_GET['action'] === 'get') {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM dokter WHERE ID_Dokter = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dokter = $result->fetch_assoc();
    echo json_encode($dokter);
  }
  exit;
}

// Konfigurasi pagination
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query

// Hitung total data dokter
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $searchQuery = "WHERE Nama LIKE '%$search%' OR ID_Dokter LIKE '%$search%'";
}
$totalDataQuery = "SELECT COUNT(*) AS total FROM dokter $searchQuery";
$totalDataResult = mysqli_query($conn, $totalDataQuery);
$totalData = mysqli_fetch_assoc($totalDataResult)['total'] ?? 0;
$totalPages = ceil($totalData / $limit);

// Ambil data dokter untuk ditampilkan
$dataQuery = "SELECT * FROM dokter $searchQuery LIMIT $limit OFFSET $offset";
$dataResult = mysqli_query($conn, $dataQuery);

$data = [];
if ($dataResult) {
  while ($row = mysqli_fetch_assoc($dataResult)) {
    $data[] = $row;
  }
} else {
  echo "Error: " . mysqli_error($conn);
}
?>

<?php include 'templates/header.php'; ?>

<aside class="sidebar d-flex flex-column align-items-center py-4 px-3 shadow">
  <!-- Admin Profile -->
  <div class="d-flex flex-column align-items-center mt-3">
    <img src="templates/img/gojo.png" alt="Admin Image" class="admin-image rounded-circle shadow" />
    <h3 class="mt-3">Admin 1</h3>
  </div>

  <!-- Menu -->
  <div class="mt-5 w-100">
    <a href="main.php" class="menu-item text-white d-flex align-items-center text-decoration-none w-100">
      <i class="fa-solid fa-file-medical"></i>
      <span>Data Pasien</span>
    </a>
    <a class="menu-item text-white d-flex align-items-center mt-3 text-decoration-none w-100">
      <i class="fa-solid fa-user-md"></i>
      <span>Data Dokter</span>
    </a>

    <!-- Button Tambah Dokter -->
    <button type="button"
      class="btn btn-none menu-item text-white d-flex align-items-center mt-3 px-3 py-2 text-decoration-none w-100"
      data-bs-toggle="modal" data-bs-target="#tambahDokterModal">
      <i class="fa-solid fa-plus"></i>
      <label>Tambah Dokter</label>
    </button>
  </div>

  <!-- Logout Button -->
  <div class="position-absolute bottom-0 mb-5">
    <a href="logout.php" class="logout-btn">
      <i class="fas fa-sign-out-alt"></i>
    </a>
  </div>
</aside>

<!-- Main Content -->
<main class="flex-grow-1 px-5 pt-5">
  <div class="d-flex align-items-center mb-4">
    <img src="templates/img/Shield.png" alt="Shield Logo" class="me-2" style="width: 60px; height: auto" />
    <h1 class="text-dark mb-0">PENS HOSPITAL</h1>
  </div>

  <!-- Tabel Dokter -->
  <div class="bg-white px-5 py-4 mt-2 shadow-sm rounded-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Data Dokter</h2>

      <!-- Search Form -->
      <form action="" method="GET" class="d-flex w-50">
        <input type="text" name="search" class="form-control" placeholder="Cari Dokter..."
          value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        <button type="submit" class="btn custom-btn text-white ms-2">Cari</button>
      </form>
    </div>

    <div class="table-responsive mt-4">
      <table class="table table-hover">
        <thead class="table-primary">
          <tr>
            <th class="text-center">ID Dokter</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Spesialisasi</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">No HP</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Loop data dokter
          if (!empty($data)):
            foreach ($data as $row):
              ?>
              <tr>
                <td class="text-center ps-3"><?= htmlspecialchars($row["ID_Dokter"]); ?></td>
                <td class="text-center"><?= htmlspecialchars($row["Nama"]); ?></td>
                <td class="text-center"><?= htmlspecialchars($row["Spesialisasi"]); ?></td>
                <td class="text-center"><?= htmlspecialchars($row["Alamat"]); ?></td>
                <td class="text-center"><?= htmlspecialchars($row["No_Hp"]); ?></td>
                <td class="d-flex justify-content-evenly pe-3">
                  <a href="editDokter.php?ID_Dokter=<?= htmlspecialchars($row['ID_Dokter'], ENT_QUOTES) ?>"
                    class="btn-edit-dokter" style="text-decoration: none;">
                    <i class="fa-solid fa-pen-to-square fa-lg me-2"></i>
                  </a>
                  <form action="function.php" method="POST" style="display:inline;">
                    <input type="hidden" name="ID_Dokter" value="<?= htmlspecialchars($row['ID_Dokter'], ENT_QUOTES); ?>">
                    <input type="hidden" name="action" value="hapus">
                    <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                      <i class="fas fa-trash hover:text-red-800 text-lg cursor-pointer"></i>
                    </button>
                  </form>
                </td>
              </tr>
              <?php
            endforeach;
          else:
            echo "<tr><td colspan='6' class='text-center'>Data Dokter tidak tersedia.</td></tr>";
          endif;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</main>

<!-- Modal Tambah Dokter -->
<div class="modal fade" id="tambahDokterModal" tabindex="-1" aria-labelledby="tambahDokterModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="background-color: #2196f3;" class="modal-header text-white">
        <h5 class="modal-title px-4" id="tambahDokterModalLabel">Tambah Data Dokter</h5>
        <button type="button" class="btn-close text-white me-4" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-5">
        <form action="function.php" method="post">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="Nama" class="form-control" placeholder="ex: AURA SASI KIRANA" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="Email" class="form-control" placeholder="ex: aurasasi@mail.com">
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Jenis Kelamin</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="laki-laki" value="Laki - laki"
                    required>
                  <label class="form-check-label" for="laki-laki">Laki-laki</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="perempuan" value="Perempuan"
                    required>
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
              <input type="date" id="tanggal-lahir" name="Tanggal_Lahir" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="Alamat" class="form-control" rows="3" required></textarea>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="npi" class="form-label">NPI</label>
              <input type="text" id="npi" name=" NPI" class="form-control" placeholder="123456789" required>
            </div>
            <div class="col-md-6">
              <label for="no-hp" class="form-label">Nomor HP</label>
              <input type="text" id="no-hp" name="No_Hp" class="form-control" placeholder="0812345xxxxx" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="spesialisasi" class="form-label">Spesialisasi</label>
              <input type="text" id="spesialisasi" name="Spesialisasi" class="form-control"
                placeholder="ex: Spesialis Jantung">
            </div>
            <div class="col-md-6">
              <label for="tanggal-lisensi" class="form-label">Tanggal Lisensi</label>
              <input type="date" id="tanggal-lisensi" name="Tanggal_Lisensi" class="form-control" required>
            </div>
          </div>
          <div class="text-end my-4">
            <button type="submit" name="action" value="tambah" class="btn btn-primary">Tambah Dokter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>

