<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php');
    exit;
}

?>
<?php include 'templates/header.php'; ?>
<aside class="sidebar d-flex flex-column align-items-center p-4 shadow">
    <!-- Admin Profile -->
    <div class="d-flex flex-column align-items-center mt-3">
        <img src="templates/img/gojo.png" alt="Admin Image" class="admin-image rounded-circle shadow" />
        <h3 class="mt-3">Admin 1</h3>
    </div>

    <!-- Menu -->
    <div class="mt-5 w-100">
        <a class="menu-item text-white d-flex align-items-center text-decoration-none w-100">
            <i class="fa-solid fa-file-medical"></i>
            <span>Data Pasien</span>
        </a>
        <a href="mainDokter.php" class="menu-item text-white d-flex align-items-center mt-3 text-decoration-none w-100">
            <i class="fa-solid fa-user-md"></i>
            <span>Data Dokter</span>
        </a>
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

    <!-- Tabel Pasien -->
    <div class="bg-white px-5 py-4 mt-2 shadow-sm rounded-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Data Pasien</h2>
            <!-- Search Form -->
            <form action="" method="GET" class="d-flex w-50">
                <input type="text" name="search" class="form-control flex-grow-1" placeholder="Cari Pasien..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit" class="btn custom-btn text-white ms-2">Cari</button>
            </form>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center ps-3">ID Pasien</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Nama Ibu</th>
                        <th class="text-center">Tanggal Lahir</th>
                        <th class="text-center">No_HP</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $apiUrl = "https://rawat-jalan.pockethost.io/api/collections/pasien/records";
                    $data = json_decode(file_get_contents($apiUrl), true);

                    // Jumlah data per halaman
                    $limit = 5;
                    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $totalItems = isset($data['items']) ? count($data['items']) : 0;
                    $totalPages = ceil($totalItems / $limit);

                    // Pencarian
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchTerm = strtolower($_GET['search']);
                        $data['items'] = array_filter($data['items'], function ($item) use ($searchTerm) {
                            return strpos(strtolower($item['id']), $searchTerm) !== false ||
                                strpos(strtolower($item['nama_lengkap']), $searchTerm) !== false ||
                                strpos(strtolower($item['nama_ibu']), $searchTerm) !== false ||
                                strpos(strtolower($item['tanggal_lahir']), $searchTerm) !== false ||
                                strpos(strtolower($item['no_telp']), $searchTerm) !== false;
                        });
                        $totalItems = count($data['items']);
                        $totalPages = ceil($totalItems / $limit);
                    }

                    // Pagination
                    $startIndex = ($currentPage - 1) * $limit;
                    $items = array_slice($data['items'], $startIndex, $limit);

                    if (!empty($items)) :
                        foreach ($items as $item) :
                    ?>
                            <tr>
                                <td class="text-center ps-3"><?= htmlspecialchars($item["id"]); ?></td>
                                <td class="text-center"><?= htmlspecialchars($item["nama_lengkap"]); ?></td>
                                <td class="text-center"><?= htmlspecialchars($item["nama_ibu"]); ?></td>
                                <td class="text-center"><?= htmlspecialchars($item["tanggal_lahir"]); ?></td>
                                <td class="text-center"><?= htmlspecialchars($item["no_telp"]); ?></td>
                                <td class="text-center pe-3">
                                    <a href="detail.php?id=<?= htmlspecialchars($item['id']); ?>" class="">
                                        <i class="fa-solid fa-eye fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Data pasien tidak tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <?php
                // Pagination logic
                $visiblePages = 5;
                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                $endPage = min($totalPages, $startPage + $visiblePages - 1);

                if ($endPage - $startPage + 1 < $visiblePages) {
                    $startPage = max(1, $endPage - $visiblePages + 1);
                }

                $baseUrl = '?';
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $baseUrl .= 'search=' . urlencode($_GET['search']) . '&';
                }
                ?>

                <!-- Previous -->
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl; ?>page=<?= $currentPage - 1; ?>" aria-label="Previous">&laquo;</a>
                    </li>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="<?= $baseUrl; ?>page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next -->
                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl; ?>page=<?= $currentPage + 1; ?>" aria-label="Next">&raquo;</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>
</main>

<?php include 'templates/footer.php'; ?>
