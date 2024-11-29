<?php include 'templates/header.php'; ?>

<!-- Main Content -->
<div class="flex-grow-1 p-4">
    <div class="bg-white p-5 shadow rounded">
        <h1>Welcome to Admin Dashboard</h1>
        <p class="text-muted">Manage your data efficiently with our tools.</p>
    </div>

    <!-- Tabel Pasien -->
    <div class="bg-white p-5 mt-4 shadow rounded">
        <h2>Data Pasien</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID Pasien</th>
                        <th>Nama</th>
                        <th>Spesialisasi</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // API URL
                    $apiUrl = "http://202.10.36.253:3001/api/dokter";
                    $data = json_decode(file_get_contents($apiUrl), true);

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
                                <td><?= $row["ID_Dokter"]; ?></td>
                                <td><?= $row["Nama"]; ?></td>
                                <td><?= $row["Spesialisasi"]; ?></td>
                                <td><?= $row["Alamat"]; ?></td>
                                <td><?= $row["No_Hp"]; ?></td>
                                <td>
                                    <a href="Rekam_medis/detail/<?= htmlspecialchars($row['ID_Dokter']); ?>" class="">
                                        <i class="fa-solid fa-eye fa-lg"></i>
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
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

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
</div>

<?php include 'templates/footer.php'; ?>
