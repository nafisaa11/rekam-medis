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
    $jenis_kelamin = $_POST['Jenis_Kelamin'];
    $tanggal_lahir = $_POST['Tanggal_Lahir'];
    $alamat = $_POST['Alamat'];

    $query = "UPDATE dokter SET Nama=?, Email=?, Jenis_Kelamin=?, Tanggal_Lahir=?, Alamat=? WHERE ID_Dokter=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $nama, $email, $jenis_kelamin, $tanggal_lahir, $alamat, $id_dokter);

    if ($stmt->execute()) {
        echo "<script>alert('Data dokter berhasil diperbarui!'); window.location.href = 'mainDokter.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
<aside class="sidebar d-flex flex-column align-items-center p-4">
    <!-- Sidebar tetap sama -->
</aside>
<main class="flex-grow-1 p-4 mx-5">
    <div class="d-flex align-items-center mb-4">
        <img src="templates/img/Shield.png" alt="Shield Logo" class="me-3" style="width: 60px; height: auto" />
        <h2 class="fw-bold text-primary mb-0">Edit Data Dokter</h2>
    </div>

    <div class="card shadow border-0 pb-5">
        <div class="card-body px-5 mx-5">
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

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include 'templates/footer.php'; ?>
