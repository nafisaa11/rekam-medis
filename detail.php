<?php include 'templates/header.php'; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-4">
    <div class="container">
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
                <div class="col-md-6">
                    <p><strong>Nama:</strong> John Doe</p>
                    <p><strong>Jenis Kelamin:</strong> Laki-laki</p>
                    <p><strong>Tanggal Lahir:</strong> 01-01-1990</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Ibu:</strong> Jane Doe</p>
                    <p><strong>Alamat:</strong> Jl. Kebon Jeruk No. 12</p>
                    <p><strong>No. Telepon:</strong> 08123456789</p>
                </div>
            </div>

            <!-- Tabel Rekam Medis -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Keluhan</th>
                            <th class="text-center">Dokter</th>
                            <th class="text-center">Lihat Rekam Medis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Dummy -->
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">20-11-2024</td>
                            <td class="text-center">Demam Tinggi</td>
                            <td class="text-center">Dr. Smith</td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#rekamMedisModal1">
                                    Lihat
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">18-11-2024</td>
                            <td class="text-center">Sakit Kepala</td>
                            <td class="text-center">Dr. Watson</td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#rekamMedisModal2">
                                    Lihat
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal Detail Rekam Medis -->
<div class="modal fade" id="rekamMedisModal1" tabindex="-1" aria-labelledby="rekamMedisModal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekamMedisModal1Label">Detail Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Tanggal:</strong> 20-11-2024</p>
                <p><strong>Keluhan:</strong> Demam Tinggi</p>
                <p><strong>Dokter:</strong> Dr. Smith</p>
                <p><strong>Detail:</strong> Pasien mengalami demam tinggi selama tiga hari terakhir.</p>
                <p><strong>Jenis Pemeriksaan:</strong> Pemeriksaan Fisik</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rekamMedisModal2" tabindex="-1" aria-labelledby="rekamMedisModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekamMedisModal2Label">Detail Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Tanggal:</strong> 18-11-2024</p>
                <p><strong>Keluhan:</strong> Sakit Kepala</p>
                <p><strong>Dokter:</strong> Dr. Watson</p>
                <p><strong>Detail:</strong> Pasien mengalami sakit kepala selama satu minggu terakhir.</p>
                <p><strong>Jenis Pemeriksaan:</strong> Pemeriksaan Darah</p>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
