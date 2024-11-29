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
                <a href="main.php"
                class="text-decoration-none text-white w-100">
                Data Pasien
                </a>
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
        <div class="position-absolute bottom-0 mb-5">
          <a href="Rekam_medis" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>
    </aside>

<!-- Main Content -->
<main class="flex-grow-1 px-5 pt-5">
        <div class="d-flex align-items-center mb-4">
            <img src="templates/img/Shield.png" alt="" class="me-3" style="width: 64px;">
            <h2 class="mb-0">PENS HOSPITAL</h2>
        </div>

        <div class="bg-white rounded-3 p-4 shadow-sm">
            <div class="text-center mb-4">
                <h3>REKAM MEDIS PASIEN</h3>
            </div>

            <!-- Informasi Pasien -->
            <div class="row mb-4">
                <?php
                $id_pasien = isset($_GET['id']) ? $_GET['id'] : null;

                if (!$id_pasien) {
                    echo "<p>ID pasien tidak ditemukan.</p>";
                    exit;
                }

                // API URLs
                $apiUrlPasien = "https://rawat-jalan.pockethost.io/api/collections/pasien/records";
                $apiUrlPendaftaran = "https://rawat-jalan.pockethost.io/api/collections/pendaftaran/records";
                $apiUrlDiagnosa = "https://rawat-jalan.pockethost.io/api/collections/diagnosa/records";
                $apiUrlJadwal = "https://rawat-jalan.pockethost.io/api/collections/jadwal/records";
                $apiUrlDokter = "http://202.10.36.253:3001/api/dokter";
                $apiUrlResep = "https://rawat-jalan.pockethost.io/api/collections/resep/records";
                $apiUrlObat = "https://rawat-jalan.pockethost.io/api/collections/obat/records";

                // Ambil data pasien
                $dataPasien = json_decode(file_get_contents($apiUrlPasien), true);
                $pasien = null;

                if (isset($dataPasien['items']) && is_array($dataPasien['items'])) {
                    foreach ($dataPasien['items'] as $item) {
                        if ($item['id'] === $id_pasien) {
                            $pasien = $item;
                            break;
                        }
                    }
                }

                if ($pasien):
                ?>
                <div class="col-md-6">
                    <p><strong>Nama:</strong> <?= htmlspecialchars($pasien["nama_lengkap"]); ?></p>
                    <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($pasien["jenis_kelamin"]); ?></p>
                    <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($pasien["tanggal_lahir"]); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Ibu:</strong> <?= htmlspecialchars($pasien["nama_ibu"]); ?></p>
                    <p><strong>Alamat:</strong> <?= htmlspecialchars($pasien["alamat"]); ?></p>
                    <p><strong>No. Telepon:</strong> <?= htmlspecialchars($pasien["no_telp"]); ?></p>
                </div>
            </div>

            <!-- Tabel Rekam Medis -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Dokter</th>
                            <th class="text-center">Keluhan</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data API lainnya
                        $dataPendaftaran = json_decode(file_get_contents($apiUrlPendaftaran), true);
                        $dataDiagnosa = json_decode(file_get_contents($apiUrlDiagnosa), true);
                        $dataJadwal = json_decode(file_get_contents($apiUrlJadwal), true);
                        $dataDokter = json_decode(file_get_contents($apiUrlDokter), true);
                        $dataResep = json_decode(file_get_contents($apiUrlResep), true);

                        // Buat map dokter
                        $dokterMap = [];
                        if (isset($dataDokter['payload']) && is_array($dataDokter['payload'])) {
                            foreach ($dataDokter['payload'] as $dokter) {
                                $dokterMap[$dokter['ID_Dokter']] = $dokter['Nama'];
                            }
                        }

                        // Buat map jadwal dan diagnosa
                        $jadwalMap = [];
                        if (isset($dataJadwal['items']) && is_array($dataJadwal['items'])) {
                            foreach ($dataJadwal['items'] as $jadwal) {
                                $jadwalMap[$jadwal['pendaftaran']] = $jadwal;
                            }
                        }

                        $diagnosaMap = [];
                        if (isset($dataDiagnosa['items']) && is_array($dataDiagnosa['items'])) {
                            foreach ($dataDiagnosa['items'] as $diagnosa) {
                                $diagnosaMap[$diagnosa['jadwal']] = $diagnosa;
                            }
                        }

                        //buat map resep
                        $resepMap = [];
                        if (isset($dataResep['items']) && is_array($dataResep['items'])) {
                            foreach ($dataResep['items'] as $resep) {
                                $resepMap[$resep['id']] = $resep;
                            }
                        }


                        // Filter pendaftaran berdasarkan pasien
                        $rekamMedis = [];
                        if (isset($dataPendaftaran['items']) && is_array($dataPendaftaran['items'])) {
                            foreach ($dataPendaftaran['items'] as $pendaftaran) {
                                if ($pendaftaran['pasien'] === $id_pasien) {
                                    $rekamMedis[] = $pendaftaran;
                                }
                            }
                        }

                        

                        // Tampilkan data rekam medis
                        if (count($rekamMedis) > 0):
                            $no = 1;
                            foreach ($rekamMedis as $medis):
                                $jadwal = $jadwalMap[$medis['id']] ?? null;
                                $diagnosa = $jadwal ? ($diagnosaMap[$jadwal['id']] ?? null) : null;
                                $keluhan = $diagnosa['keluhan'] ?? '-';
                                $detail = $diagnosa['detail'] ?? '-';
                                $jenisLayanan = $diagnosa['jenis_layanan'] ?? '-';
                                $jenisPemeriksaan = $diagnosa['jenis_pemeriksaan'] ?? '-';
                                $prioritas = $diagnosa['prioritas'] ?? '-';
                                $catatan = $diagnosa['catatan'] ?? '-';
                                $dokterNama = $dokterMap[$medis['dokter']] ?? 'Dokter Tidak Ditemukan';
                                $resep = $resepMap[$diagnosa['id']] ?? null;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <td class="text-center"><?= htmlspecialchars($medis["tanggal"]); ?></td>
                            <td class="text-center"><?= htmlspecialchars($dokterNama); ?></td>
                            <td class="text-center"><?= htmlspecialchars($keluhan); ?></td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#rekamMedisModal<?= $no; ?>">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="rekamMedisModal<?= $no; ?>" tabindex="-1" aria-labelledby="rekamMedisModalLabel<?= $no; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekamMedisModalLabel<?= $no; ?>">Detail Rekam Medis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Tanggal:</strong> <?= htmlspecialchars($medis["tanggal"]); ?></p>
                                        <p><strong>Dokter:</strong> <?= htmlspecialchars($dokterNama); ?></p>
                                        <p><strong>Keluhan:</strong> <?= htmlspecialchars($keluhan); ?></p>
                                        <p><strong>Diagnosa:</strong> <?= htmlspecialchars($detail); ?></p>
                                        <p><strong>Jenis Layanan:</strong> <?= htmlspecialchars($jenisLayanan); ?></p>
                                        <p><strong>Jenis Layanan:</strong> <?= htmlspecialchars($jenisPemeriksaan); ?></p>
                                        <p><strong>Prioritas:</strong> <?= htmlspecialchars($prioritas); ?></p>
                                        <p><strong>Catatan:</strong> <?= htmlspecialchars($catatan); ?></p>
                                        <p><strong>Resep:</strong> <?= $resep ? htmlspecialchars($resep['resep']) : '-'; ?></p>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $no++;
                            endforeach;
                        else:
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p>Data pasien tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'templates/footer.php'; ?>
