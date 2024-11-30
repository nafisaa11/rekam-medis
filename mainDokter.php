<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php'); 
    exit;
}

?>
<?php include 'controllers/dokterController.php';?>
<?php include 'templates/header.php';?>

<aside class="sidebar d-flex flex-column align-items-center py-4 px-3 shadow">
    <!-- Admin Profile -->
    <div class="d-flex flex-column align-items-center mt-3">
        <img src="templates/img/gojo.png" alt="Admin Image" class="admin-image rounded-circle shadow" />
        <h3 class="mt-3">Admin 1</h3>
    </div>

  <!-- Menu -->
  <div class="mt-5 w-100">
    <!-- Data Pasien -->
    <a href="main.php" class="menu-item text-white d-flex align-items-center text-decoration-none w-100">
        <i class="fa-solid fa-file-medical"></i>
        <span>Data Pasien</span>
    </a>

    <!-- Data Dokter -->
    <a class="menu-item text-white d-flex align-items-center mt-3 text-decoration-none w-100">
        <i class="fa-solid fa-user-md"></i>
        <span>Data Dokter</span>
    </a>
    
    <!-- button Tambah Dokter -->
    <button type="button" class="btn btn-none menu-item text-white d-flex align-items-center mt-3 px-3 py-2text-decoration-none w-100" data-bs-toggle="modal" data-bs-target="#tambahDokterModal">
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
    <img
      src="templates/img/Shield.png"
      alt="Shield Logo"
      class="me-2"
      style="width: 60px; height: auto" />
    <h1 class="text-dark mb-0">PENS HOSPITAL</h1>
  </div>

  <!-- Tabel Dokter -->
  <div class="bg-white px-5 py-4 mt-2 shadow-sm rounded-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Data Dokter</h2>

      <!-- Search Form -->
      <form action="" method="GET" class="d-flex w-50">
        <input type="text" name="search" class="form-control" placeholder="Cari Pasien..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
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
          // API URL
          $apiUrl = "http://202.10.36.253:3001/api/dokter";
          $data = json_decode(file_get_contents($apiUrl), true);

          // Search Functionality
          if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = strtolower($_GET['search']);
            $data['payload'] = array_filter($data['payload'], function ($row) use ($searchTerm) {
              // Cari di semua kolom: ID_Dokter, Nama, Spesialisasi, Alamat, No_Hp
              return strpos(strtolower($row['ID_Dokter']), $searchTerm) !== false ||
                strpos(strtolower($row['Nama']), $searchTerm) !== false ||
                strpos(strtolower($row['Spesialisasi']), $searchTerm) !== false ||
                strpos(strtolower($row['Alamat']), $searchTerm) !== false ||
                strpos(strtolower($row['No_Hp']), $searchTerm) !== false;
            });
          }

          // Pagination Variables
          $itemsPerPage = 5; // Jumlah data per halaman
          $totalItems = isset($data['payload']) ? count($data['payload']) : 0; // Total data
          $totalPages = ceil($totalItems / $itemsPerPage); // Total halaman
          $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman aktif
          $currentPage = max(1, min($currentPage, $totalPages)); // Validasi halaman aktif

          // Data yang ditampilkan per halaman
          $offset = ($currentPage - 1) * $itemsPerPage;
          $paginatedData = isset($data['payload']) ? array_slice($data['payload'], $offset, $itemsPerPage) : [];

          // Loop data pasien
          if (!empty($paginatedData)):
            foreach ($paginatedData as $row):
          ?>
              <tr>
                <td class="text-center ps-3"><?= $row["ID_Dokter"]; ?></td>
                <td class="text-center"><?= $row["Nama"]; ?></td>
                <td class="text-center"><?= $row["Spesialisasi"]; ?></td>
                <td class="text-center"><?= $row["Alamat"]; ?></td>
                <td class="text-center"><?= $row["No_Hp"]; ?></td>
                <td class="d-flex justify-content-evenly pe-3">
                  <a href="editDokter.php/<?= htmlspecialchars($row['ID_Dokter']); ?>" style="text-decoration: none;">
                    <i class="fa-solid fa-pen-to-square fa-lg me-2"></i>
                  </a>
                  <a href="controllers/dokterController.php?ID_Dokter=<?= htmlspecialchars($row['ID_Dokter'] ?? '', ENT_QUOTES) ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash hover:text-red-800 text-lg cursor-pointer"></i>
                  </a>
                </td>
              </tr>
          <?php
            endforeach;
          else:
            echo "<tr><td colspan='6' class='text-center'>Data pasien tidak tersedia.</td></tr>";
          endif;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <?php
            // Tentukan jumlah halaman yang ditampilkan dalam satu waktu
            $visiblePages = 5;

            // Tentukan awal dan akhir dari rentang halaman
            $startPage = max(1, $currentPage - floor($visiblePages / 2));
            $endPage = min($totalPages, $startPage + $visiblePages - 1);

            // Sesuaikan jika berada di akhir halaman
            if ($endPage - $startPage + 1 < $visiblePages) {
                $startPage = max(1, $endPage - $visiblePages + 1);
            }

            // URL dasar dengan parameter search jika ada
            $baseUrl = '?';
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $baseUrl .= 'search=' . urlencode($_GET['search']) . '&';
            }
            ?>

            <!-- Tombol Previous -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $baseUrl; ?>page=<?= $currentPage - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Halaman yang Ditampilkan -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?= $baseUrl; ?>page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $baseUrl; ?>page=<?= $currentPage + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="tambahDokterModal" tabindex="-1" aria-labelledby="tambahDokterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="background-color: #2196f3;" class="modal-header text-white">
        <h5 class="modal-title px-4" id="tambahDokterModalLabel">Tambah Data Dokter</h5>
        <button type="button" class="btn-close text-white me-4" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-5">
        <form action="" method="post">
          
          <!-- Nama -->
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="Nama" class="form-control" placeholder="ex: AURA SASI KIRANA" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="Email" class="form-control" placeholder="ex: aurasasi@mail.com">
          </div>

          <!-- Jenis Kelamin dan Tanggal Lahir -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Jenis Kelamin</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="laki-laki" value="Laki - laki" required>
                  <label class="form-check-label" for="laki-laki">Laki-laki</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="perempuan" value="Perempuan" required>
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
              <input type="date" id="tanggal-lahir" name="Tanggal_Lahir" class="form-control" required>
            </div>
          </div>

          <!-- Alamat -->
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="Alamat" class="form-control" rows="3" required></textarea>
          </div>

          <!-- NPI dan Nomor HP -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="npi" class="form-label">NPI</label>
              <input type="text" id="npi" name="NPI" class="form-control" placeholder="123456789" required>
            </div>
            <div class="col-md-6">
              <label for="no-hp" class="form-label">Nomor HP</label>
              <input type="text" id="no-hp" name="No_Hp" class="form-control" placeholder="0812345xxxxx" required>
            </div>
          </div>

          <!-- Spesialisasi dan Tanggal Lisensi -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="spesialisasi" class="form-label">Spesialisasi</label>
              <input type="text" id="spesialisasi" name="Spesialisasi" class="form-control" placeholder="ex: Spesialis Jantung">
            </div>
            <div class="col-md-6">
              <label for="tanggal-lisensi" class="form-label">Tanggal Lisensi</label>
              <input type="date" id="tanggal-lisensi" name="Tanggal_Lisensi" class="form-control" required>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-end my-4">
            <button type="submit" name="simpanDokter" class="btn btn-primary">Tambah Dokter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>