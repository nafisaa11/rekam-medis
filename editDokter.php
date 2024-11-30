<?php
include 'templates/header.php';

// Konfigurasi koneksi database
$mysqli = new mysqli("localhost", "root", "", "rekam_medis");

// Periksa koneksi database
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil ID_Dokter dari URL
$id_dokter = isset($_GET['ID_Dokter']) ? $_GET['ID_Dokter'] : null;

// Validasi ID_Dokter
if (!$id_dokter) {
    echo "<script>alert('ID Dokter tidak ditemukan!'); window.location.href = 'mainDokter.php';</script>";
    exit;
}

// Query data dokter berdasarkan ID_Dokter
$query = "SELECT * FROM dokter WHERE ID_Dokter = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $id_dokter);
$stmt->execute();
$result = $stmt->get_result();
$dokter = $result->fetch_assoc();
$stmt->close();

// Cek apakah data dokter ditemukan
if (!$dokter) {
    echo "<script>alert('Data dokter tidak ditemukan!'); window.location.href = 'mainDokter.php';</script>";
    exit;
}

// Proses update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['Nama'];
    $email = $_POST['Email'];
    $pasword = 12345;
    $jenis_kelamin = $_POST['Jenis_Kelamin'];
    $tanggal_lahir = $_POST['Tanggal_Lahir'];
    $alamat = $_POST['Alamat'];
    $npi = $_POST['NPI'];
    $no_hp = $_POST['No_Hp'];
    $spesialisasi = $_POST['Spesialisasi'];
    $tanggal_lisensi = $_POST['Tanggal_Lisensi'];

    $query = "UPDATE dokter SET Nama=?, Email=?, Jenis_Kelamin=?, Tanggal_Lahir=?, Alamat=?, NPI=?, No_Hp=?, Spesialisasi=?, Tanggal_Lisensi=? WHERE ID_Dokter=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssssssss", $nama, $email, $jenis_kelamin, $tanggal_lahir, $alamat, $npi, $no_hp, $spesialisasi, $tanggal_lisensi, $id_dokter);

    if ($stmt->execute()) {
        echo "<script>alert('Data dokter berhasil diperbarui!'); window.location.href = 'mainDokter.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
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
</aside>

<main class="flex-grow-1 p-4 mx-5">
    <div class="d-flex align-items-center mb-4">
        <img src="templates/img/Shield.png" alt="Shield Logo" class="me-2" style="width: 60px; height: auto" />
        <h1 class="text-dark mb-0">PENS HOSPITAL</h1>
    </div>

    <div class="bg-white px-5 py-4 mt-2 mb-5 shadow-sm rounded-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Data Dokter</h2>
        </div>

        <hr style="border: none; height: 1px; background-color: #000; margin: 20px 0;">


            <form action="" method="POST">
                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="Nama" class="form-control" value="<?= htmlspecialchars($dokter['Nama']) ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="Email" class="form-control" value="<?= htmlspecialchars($dokter['Email']) ?>">
                </div>

                <!-- Jenis Kelamin -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="laki-laki" value="Laki - Laki" 
                                    <?= $dokter['Jenis_Kelamin'] === 'Laki - Laki' ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Jenis_Kelamin" id="perempuan" value="Perempuan" 
                                    <?= $dokter['Jenis_Kelamin'] === 'Perempuan' ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" id="tanggal-lahir" name="Tanggal_Lahir" class="form-control" value="<?= htmlspecialchars($dokter['Tanggal_Lahir']) ?>" required>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="Alamat" class="form-control" rows="3" required><?= htmlspecialchars($dokter['Alamat']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <!-- NPI -->
                    <div class="col-md-6">
                        <label for="npi" class="form-label">NPI</label>
                        <input type="text" id="npi" name="NPI" class="form-control" value="<?= htmlspecialchars($dokter['NPI']) ?>" required>
                    </div>

                    <!-- No.HP  -->
                    <div class="col-md-6">
                        <label for="no-hp" class="form-label">No. HP</label>
                        <input type="text" id="no-hp" name="No_Hp" class="form-control" value="<?= htmlspecialchars($dokter['No_Hp']) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Spesialisasi -->
                    <div class="col-md-6">
                        <label for="spesialisasi" class="form-label">Spesialisasi</label>
                        <input type="text" id="spesialisasi" name="Spesialisasi" class="form-control" value="<?= htmlspecialchars($dokter['Spesialisasi']) ?>" required>
                    </div>

                    <!-- Tanggal Lisensi -->
                    <div class="col-md-6">
                        <label for="tanggal-lisensi" class="form-label">Tanggal Lisensi</label>
                        <input type="date" id="tanggal-lisensi" name="Tanggal_Lisensi" class="form-control" value="<?= htmlspecialchars($dokter['Tanggal_Lisensi']) ?>" required>
                    </div>
                </div>
                

                <!-- Submit Button -->
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">Simpan Perubahan</button>
                </div>
            </form>
    </div>
</main>
<?php include 'templates/footer.php'; ?>