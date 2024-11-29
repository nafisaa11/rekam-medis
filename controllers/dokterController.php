<?php
// Koneksi ke API
$url = 'http://202.10.36.253:3001/api/dokter/';

// Fungsi untuk generate ID Dokter
function generateIdDokter() {
    $prefix = "DPENSH";

    // Inisialisasi cURL untuk mendapatkan ID terakhir
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        // Mendapatkan data dalam format JSON
        $dokters = json_decode($response, true);
        // Ambil ID terakhir
        $lastDokter = end($dokters); // Ambil dokter terakhir
        $lastNumber = (int) substr($lastDokter['ID_Dokter'], -5);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Jika belum ada data, mulai dari 1
    }

    $formattedNumber = str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    return $prefix . $formattedNumber;
}

// Proses tambah atau edit data dokter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = isset($_POST['ID_Dokter']) ? $_POST['ID_Dokter'] : null; // ID untuk edit
    $nama = $_POST['Nama'];
    $email = $_POST['Email'];
    $jenis_kelamin = $_POST['Jenis_Kelamin'];
    $tanggal_lahir = $_POST['Tanggal_Lahir'];
    $alamat = $_POST['Alamat'];
    $npi = $_POST['NPI'];
    $no_hp = $_POST['No_Hp'];
    $spesialisasi = $_POST['Spesialisasi'];
    $tanggal_lisensi = $_POST['Tanggal_Lisensi'];

    // Generate ID Dokter jika belum ada ID
    if (!$id) {
        $id = generateIdDokter();
    }

    // Siapkan data untuk dikirim
    $dokterData = [
        'ID_Dokter' => $id,
        'Nama' => $nama,
        'Email' => $email,
        'Jenis_Kelamin' => $jenis_kelamin,
        'Tanggal_Lahir' => $tanggal_lahir,
        'Alamat' => $alamat,
        'NPI' => $npi,
        'No_Hp' => $no_hp,
        'Spesialisasi' => $spesialisasi,
        'Tanggal_Lisensi' => $tanggal_lisensi
    ];

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($id) {
        // Untuk edit, gunakan metode PUT
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_URL, $url . $id); // Menambahkan ID pada URL
    } else {
        // Untuk tambah, gunakan metode POST
        curl_setopt($ch, CURLOPT_POST, true);
    }

    // Kirim data sebagai JSON
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dokterData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    // Eksekusi cURL
    $response = curl_exec($ch);
    curl_close($ch);

    // Cek apakah data berhasil ditambahkan/diubah
    if ($response) {
        header("Location: index.php?status=success");
        exit;
    } else {
        echo "Terjadi kesalahan, data dokter gagal ditambahkan/diubah.";
    }
}


// Fungsi untuk Delete Data
if (isset($_GET['ID_Dokter'])) {
    $id_dokter = $_GET['ID_Dokter'];

    // Query untuk delete data
    $query = "DELETE FROM Dokter WHERE ID_Dokter = :id_dokter";
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":id_dokter", $id_dokter);

    if (oci_execute($stid)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='../index.php';</script>";
    } else {
        $error = oci_error($stid);
        echo "<script>alert('Gagal menghapus data: " . htmlspecialchars($error['message']) . "');</script>";
    }

    oci_free_statement($stid);
} else {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='../index.php';</script>";
}
?>