      <?php include 'templates/header.php';?>

      <aside class="sidebar d-flex flex-column align-items-center p-4">
        <!-- Admin Profile -->
        <div class="d-flex flex-column align-items-center">
          <img
            src="templates/img/gojo.png"
            alt="Admin Image"
            class="admin-image rounded-circle shadow"
          />
          <h3 class="mt-3">Admin 1</h3>
        </div>

        <!-- Menu -->
        <div class="mt-5 w-100">
          <div class="menu-item text-white d-flex align-items-center">
            <i class="fa-solid fa-file-medical"></i>
            <a 
              href="main.php"
              class="text-decoration-none text-white w-100"
            >
              Data Pasien
            </a>
          </div>
          <div class="menu-item text-white d-flex align-items-center mt-3">
            <i class="fa-solid fa-user-md"></i>
            <a
              class="text-decoration-none text-white w-100"
              >Data Dokter</a
            >
          </div>
          <div class="menu-item text-white d-flex align-items-center mt-3">
          <i class="fa-solid fa-plus"></i>
            <a
              href="tambahDokter.php"
              class="text-decoration-none text-white w-100"
              >Tambah Dokter</a
            >
          </div>
        </div>

        <!-- Logout Button -->
        <div class="position-absolute bottom-0 mb-3">
          <a href="Rekam_medis" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>
      </aside>
      
      <!-- Main Content -->
      <main class="flex-grow-1 p-4">
        <div class="d-flex align-items-center mb-4">
          <img
            src="templates/img/Shield.png"
            alt="Shield Logo"
            class="me-3"
            style="width: 60px; height: auto"
          />
          <h2 class="fw-bold text-primary mb-0">PENS HOSPITAL</h2>
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
</main>


<?php include 'templates/footer.php'; ?>
