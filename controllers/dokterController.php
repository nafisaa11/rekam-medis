<?php
// Database connection
$host = 'localhost';
$dbname = 'rekam_medis';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpanDokter'])) {
        // Retrieve form data
        $nama = $_POST['Nama'];
        $email = $_POST['Email'];
        $password = password_hash("12345", PASSWORD_BCRYPT); // Hash the default password for security
        $jenis_kelamin = $_POST['Jenis_Kelamin'];
        $tanggal_lahir = $_POST['Tanggal_Lahir'];
        $alamat = $_POST['Alamat'];
        $npi = $_POST['NPI'];
        $no_hp = $_POST['No_Hp'];
        $spesialisasi = $_POST['Spesialisasi'];
        $tanggal_lisensi = $_POST['Tanggal_Lisensi'];

        // Generate new ID_Dokter
        $id_dokter = generateIdDokter($pdo);

        // Prepare and execute insert query
        $stmt = $pdo->prepare("INSERT INTO dokter (ID_Dokter, Nama, Email, Password, Jenis_Kelamin, Tanggal_Lahir, Alamat, NPI, No_Hp, Spesialisasi, Tanggal_Lisensi) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_dokter, $nama, $email, $password, $jenis_kelamin, $tanggal_lahir, $alamat, $npi, $no_hp, $spesialisasi, $tanggal_lisensi]);

        echo "<script>
                alert('Data dokter berhasil ditambahkan!');
                window.location.href = 'mainDokter.php';
              </script>";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Function to generate a new ID_Dokter
function generateIdDokter($pdo) {
    $prefix = "DPENSH";

    // Query to get the last ID_Dokter
    $stmt = $pdo->query("SELECT ID_Dokter FROM dokter ORDER BY ID_Dokter DESC LIMIT 1");
    $lastDokter = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastDokter) {
        $lastNumber = (int) substr($lastDokter['ID_Dokter'], -5); // Extract the numeric part
        $newNumber = $lastNumber + 1; // Increment the number
    } else {
        $newNumber = 1; // If no data exists, start from 1
    }

    // Format the new number as a 5-digit string
    $formattedNumber = str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    return $prefix . $formattedNumber; // Combine prefix and formatted number
}

// Fungsi untuk Delete Data
// if (isset($_GET['ID_Dokter'])) {
//     $id_dokter = $_GET['ID_Dokter'];

//     // Query untuk delete data
//     $query = "DELETE FROM Dokter WHERE ID_Dokter = :id_dokter";
//     $stid = oci_parse($conn, $query);

//     oci_bind_by_name($stid, ":id_dokter", $id_dokter);

//     if (oci_execute($stid)) {
//         echo "<script>alert('Data berhasil dihapus!'); window.location.href='mainDokter.php';</script>";
//     } else {
//         $error = oci_error($stid);
//         echo "<script>alert('Gagal menghapus data: " . htmlspecialchars($error['message']) . "');</script>";
//     }

//     oci_free_statement($stid);
// } else {
//     echo "<script>alert('Data tidak ditemukan!'); window.location.href='mainDokter.php';</script>";
// }
?>