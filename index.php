<?php include 'templates/header.php';?>

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

    <?php include 'templates/footer.php';?>