<?php include 'templates/header.php'; ?>

<aside class="sidebar d-flex flex-column align-items-center p-4">
    <!-- Admin Profile -->
    <div class="d-flex flex-column align-items-center mt-3">
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
            <span>Data Pasien</span>
        </div>
        <div class="menu-item text-white d-flex align-items-center mt-3">
            <i class="fa-solid fa-user-md"></i>
            <a
                href="mainDokter.php"
                class="text-decoration-none text-white w-100"
            >Data Dokter</a>
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
        <img
            src="templates/img/Shield.png"
            alt="Shield Logo"
            class="me-3"
            style="width: 60px; height: auto"
        />
        <h2 class="fw-bold text-dark mb-0">PENS HOSPITAL</h2>
    </div>

    <!-- Tabel Pasien -->
    <div class="bg-white px-5 py-4 mt-2 shadow rounded-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Data Pasien</h2>
            <!-- Search Form -->
            <form action="" method="GET" class="d-flex w-50">
                <input type="text" name="search" class="form-control flex-grow-1" placeholder="Cari Pasien..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center ps-3">ID Pasien</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Umur</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $apiUrl = "https://rawat-jalan.pockethost.io/api/collections/pasien/records";
                    $data = json_decode(file_get_contents($apiUrl), true);

                    // Cek apakah data items tersedia di dalam hasil decode JSON
                    if (isset($data['items']) && is_array($data['items'])):
                        // Jika ada pencarian
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $searchTerm = strtolower($_GET['search']);
                            $data['items'] = array_filter($data['items'], function($item) use ($searchTerm) {
                                // Cari di semua kolom: ID Pasien, Nama, Umur, Jenis Kelamin, Alamat
                                return strpos(strtolower($item['id']), $searchTerm) !== false ||
                                       strpos(strtolower($item['nama_lengkap']), $searchTerm) !== false ||
                                       strpos(strtolower($item['nama_ibu']), $searchTerm) !== false ||
                                       strpos(strtolower($item['tanggal_lahir']), $searchTerm) !== false ||
                                       strpos(strtolower($item['no_telp']), $searchTerm) !== false ||
                                       strpos(strtolower($item['alamat']), $searchTerm) !== false;
                            });
                        }

                        // Loop melalui setiap item dalam data items
                        foreach ($data['items'] as $item):
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
                    else:
                        echo "<tr><td colspan='6' class='text-center'>Data pasien tidak tersedia.</td></tr>";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
    </div>
</main>

<?php include 'templates/footer.php'; ?>
