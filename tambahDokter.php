<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php'); 
    exit;
}

?>
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
    </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4 mx-5">
            
            <div class="d-flex align-items-center mb-4">
                <img
                    src="templates/img/Shield.png"
                    alt="Shield Logo"
                    class="me-3"
                    style="width: 60px; height: auto"
                />
                <h2 class="fw-bold mb-0">PENS HOSPITAL</h2>
            </div>

            <div class="card shadow border-0 pb-5">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold mb-0 ">TAMBAH DATA DOKTER</h3>
                </div>

                <div class="card-body px-5 mx-5">
                    <form action="" method="post">
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" name="Nama" class="form-control" placeholder="ex: AURA SASI KIRANA" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" name="Email" class="form-control" placeholder="ex: aurasasi@mail.com">
                        </div>

                        <!-- Jenis Kelamin dan Tanggal Lahir -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="laki-laki" value="Laki - laki" required>
                                        <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="perempuan" value="Perempuan" required>
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tanggal-lahir" name="Tanggal_Lahir" class="form-control" required>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="Alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <!-- NPI dan Nomor HP -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="npi" class="form-label">NPI</label>
                                <input type="text" id="npi" name="NPI" class="form-control" placeholder="123456789" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no-hp" class="form-label">Nomor HP</label>
                                <input type="text" id="no-hp" name="No_Hp" class="form-control" placeholder="0812345xxxxx" required>
                            </div>
                        </div>

                        <!-- Spesialisasi dan Tanggal Lisensi -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                <input type="text" id="spesialisasi" name="Spesialisasi" class="form-control" placeholder="ex: Spesialis Jantung">
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal-lisensi" class="form-label">Tanggal Lisensi</label>
                                <input type="date" id="tanggal-lisensi" name="Tanggal_Lisensi" class="form-control" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" name="simpanDokter" class="btn btn-primary px-4 py-2">Tambah Dokter</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>


    </div>
</div>

<?php include 'templates/footer.php'; ?>