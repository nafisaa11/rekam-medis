<?php include 'templates/header.php'; ?>

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
            <span>Data Pasien</span>
          </div>
          <div class="menu-item text-white d-flex align-items-center mt-3">
            <i class="fa-solid fa-user-md"></i>
            <a
              href="mainDokter.php"
              class="text-decoration-none text-white w-100"
              >Data Dokter</a
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
        <div class="flex-grow-1 p-4">

            <!-- Tabel Pasien -->
            <div class="bg-white p-5 mt-4 shadow rounded">
                <h2>Data Pasien</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $apiUrl = "https://rawat-jalan.pockethost.io/api/collections/pasien/records";
                            $data = json_decode(file_get_contents($apiUrl), true);


                            // Cek apakah data items tersedia di dalam hasil decode JSON
                            if (isset($data['items']) && is_array($data['items'])):
                                // Loop melalui setiap item dalam data items
                                foreach ($data['items'] as $item):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item["id"]); ?></td>
                                        <td><?= htmlspecialchars($item["nama_lengkap"]); ?></td>
                                        <td><?= htmlspecialchars($item["nama_ibu"]); ?></td>
                                        <td><?= htmlspecialchars($item["tanggal_lahir"]); ?></td>
                                        <td><?= htmlspecialchars($item["no_telp"]); ?></td>
                                        <td>
                                            <a href="Rekam_medis/detail/<?= htmlspecialchars($item['id']); ?>"
                                                class="">
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
            </div>
        </div>

    </div>
</div>

<?php include 'templates/footer.php'; ?>