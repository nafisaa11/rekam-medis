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

    $edit = mysqli_query($mysqli, "UPDATE dokter SET 
                                        Nama='$nama', 
                                        Email='$email', 
                                        Password='$pasword', 
                                        Jenis_Kelamin='$jenis_kelamin', 
                                        Tanggal_Lahir='$tanggal_lahir', 
                                        Alamat='$alamat', NPI='$npi', 
                                        No_Hp='$no_hp', 
                                        Spesialisasi='$spesialisasi', 
                                        Tanggal_Lisensi='$tanggal_lisensi' 
                                    WHERE ID_Dokter='$id_dokter'");

    // Tanggapi respons dan tampilkan pesan sukses/gagal
    if ($edit) {
        echo "<script>
                alert('Data Dokter berhasil diperbarui!');
                document.location='mainDokter.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Dokter gagal diperbarui!');
                document.location='mainDokter.php';
              </script>";
    }
}
?>




