<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php'); 
    exit;
}

?>
<?php include 'templates/header.php';?>

<aside class="sidebar d-flex flex-column align-items-center p-4">
    <!-- Admin Profile -->
    <div class="d-flex flex-column align-items-center mt-3">
        <img src="templates/img/gojo.png" alt="Admin Image" class="admin-image rounded-circle shadow" />
        <h3 class="mt-3">Admin 1</h3>
    </div>

    <!-- Menu -->
    <div class="mt-5 w-100">
        <div class="menu-item text-white d-flex align-items-center">
            <i class="fa-solid fa-file-medical"></i>
            <a href="main.php" class="text-decoration-none text-white w-100">Data Pasien</a>
        </div>
        <div class="menu-item text-white d-flex align-items-center mt-3">
            <i class="fa-solid fa-user-md"></i>
            <a class="text-decoration-none text-white w-100">Data Dokter</a>
        </div>
        <div class="menu-item text-white d-flex align-items-center mt-3">
            <i class="fa-solid fa-plus"></i>
            <a href="tambahDokter.php" class="text-decoration-none text-white w-100">Tambah Dokter</a>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="position-absolute bottom-0 mb-5">
        <a href="Rekam_medis" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="flex-grow-1 px-5 pt-5">
    <div class="d-flex align-items-center mb-4">
        <img src="templates/img/Shield.png" alt="Shield Logo" class="me-3" style="width: 60px; height: auto" />
        <h2 class="fw-bold text-dark mb-0">PENS HOSPITAL</h2>
    </div>

    <!-- Tabel Pasien -->
    <div class="bg-white px-5 py-4 mt-2 shadow rounded-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Data Dokter</h2>

            <!-- Search Form -->
            <form action="" method="GET" class="d-flex w-50">
                <input type="text" name="search" class="form-control" placeholder="Cari Pasien..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
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
                      $data['payload'] = array_filter($data['payload'], function($row) use ($searchTerm) {
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
                                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                    </a>
                                    <a href="controllers/dokterController.php?ID_Dokter=<?= htmlspecialchars($row['ID_Dokter'] ?? '', ENT_QUOTES) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash hover:text-red-800 text-lg cursor-pointer ml-3"></i>
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
                ?>

                <!-- Tombol Previous -->
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Halaman yang Ditampilkan -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Tombol Next -->
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>

<?php include 'templates/footer.php'; ?>
