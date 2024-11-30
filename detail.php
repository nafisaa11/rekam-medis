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
        <!-- button Data Pasien -->
        <a href="main.php" class="menu-item text-white d-flex align-items-center text-decoration-none w-100">
            <i class="fa-solid fa-file-medical"></i>
            <span>Data Pasien</span>
        </a>

        <!-- button Data Dokter -->
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

    <div class="bg-white rounded-4 px-5 py-4 shadow-sm">
        <div class="text-center mb-4">
            <h2>Rekam Medis Pasien</h2>
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
                <div class="row justify-content-center flex-grow-1">
                    <table class="table table-borderless w-100 tabel-data-pasien">
                        <tbody>
                            <tr>
                                <td class="col-md-2"><strong>Nama</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["nama_lengkap"]); ?></td>
                                <td class="col-md-2"><strong>Nama Ibu</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["nama_ibu"]); ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-2"><strong>Jenis Kelamin</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["jenis_kelamin"]); ?></td>
                                <td class="col-md-2"><strong>Alamat</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["alamat"]); ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-2"><strong>Tanggal Lahir</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["tanggal_lahir"]); ?></td>
                                <td class="col-md-2"><strong>No. Telepon</strong></td>
                                <td class="col-md-4">: <?= htmlspecialchars($pasien["no_telp"]); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Tabel Rekam Medis -->
            <div class="table-responsive">
                <table class="table table-hover">
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

                        $dataObat = json_decode(file_get_contents($apiUrlObat), true);

                        // Buat map obat
                        $obatMap = [];
                        if (isset($dataObat['items']) && is_array($dataObat['items'])) {
                            foreach ($dataObat['items'] as $obat) {
                                $obatMap[$obat['resep']][] = $obat; // Group by resep ID
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
                                $obatList = $resep ? ($obatMap[$resep['id']] ?? []) : [];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= htmlspecialchars($medis["tanggal"]); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($dokterNama); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($keluhan); ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm custom-btn text-white" data-bs-toggle="modal"
                                            data-bs-target="#rekamMedisModal<?= $no; ?>">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="rekamMedisModal<?= $no; ?>" tabindex="-1"
                                    aria-labelledby="rekamMedisModalLabel<?= $no; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content px-4 py-3">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="rekamMedisModalLabel<?= $no; ?>">Detail Rekam Medis</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="mb-3">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="text" class="form-control" id="tanggal"
                                                            value="<?= htmlspecialchars($medis["tanggal"]); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dokter" class="form-label">Dokter</label>
                                                        <input type="text" class="form-control" id="dokter"
                                                            value="<?= htmlspecialchars($dokterNama); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keluhan" class="form-label">Keluhan</label>
                                                        <input type="text" class="form-control" id="keluhan"
                                                            value="<?= htmlspecialchars($keluhan); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="diagnosa" class="form-label">Diagnosa</label>
                                                        <input type="text" class="form-control" id="diagnosa"
                                                            value="<?= htmlspecialchars($detail); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenisLayanan" class="form-label">Jenis Layanan</label>
                                                        <input type="text" class="form-control" id="jenisLayanan"
                                                            value="<?= htmlspecialchars($jenisLayanan); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenisPemeriksaan" class="form-label">Jenis Pemeriksaan</label>
                                                        <input type="text" class="form-control" id="jenisPemeriksaan"
                                                            value="<?= htmlspecialchars($jenisPemeriksaan); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="prioritas" class="form-label">Prioritas</label>
                                                        <input type="text" class="form-control" id="prioritas"
                                                            value="<?= htmlspecialchars($prioritas); ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="catatan" class="form-label">Catatan</label>
                                                        <textarea class="form-control" id="catatan" rows="3"
                                                            disabled><?= htmlspecialchars($catatan); ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="obat" class="form-label">Obat</label>
                                                        <input type="text" class="form-control" id="obat"
                                                            value="<?= $obat ? htmlspecialchars($obat['nama_obat']) : '-'; ?>"
                                                         disabled>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn custom-btn text-white" data-bs-dismiss="modal">Tutup</button>
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