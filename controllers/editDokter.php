<?php
// Koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "rekam_medis");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_dokter = $_POST['ID_Dokter'];
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

    $data = [
        'ID_Dokter' => $id_dokter,
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

    // Inisialisasi cURL untuk mengirim data
    $ch = curl_init($UrlUpdate);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    // Tanggapi respons dan tampilkan pesan sukses/gagal
    if ($response === false) {
        echo "Gagal memperbarui data dokter!";
    } else {
        echo "Data dokter berhasil diperbarui!";
    }
}
?>




