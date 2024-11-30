<?php
// Database connection
$host = 'localhost';
$dbname = 'rekam_medis';
$username = 'root';
$password = '';

$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve action from form
    $action = $_POST['action'];

    if ($action === 'tambah') {
        // Retrieve form data for adding a doctor
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
        $id_dokter = generateIdDokter($mysqli);

        // Prepare and execute insert query
        $stmt = $mysqli->prepare("INSERT INTO dokter (ID_Dokter, Nama, Email, Password, Jenis_Kelamin, Tanggal_Lahir, Alamat, NPI, No_Hp, Spesialisasi, Tanggal_Lisensi) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $id_dokter, $nama, $email, $password, $jenis_kelamin, $tanggal_lahir, $alamat, $npi, $no_hp, $spesialisasi, $tanggal_lisensi);

        if ($stmt->execute()) {
            echo "<script>alert('Data dokter berhasil ditambahkan!'); window.location.href = 'mainDokter.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action === 'edit') {
        // Retrieve form data for editing a doctor
        $id_dokter = $_POST['ID_Dokter'];
        $nama = $_POST['Nama'];
        $email = $_POST['Email'];
        $jenis_kelamin = $_POST['Jenis_Kelamin'];
        $tanggal_lahir = $_POST['Tanggal_Lahir'];
        $alamat = $_POST['Alamat'];
        $npi = $_POST['NPI'];
        $no_hp = $_POST['No_Hp'];
        $spesialisasi = $_POST['Spesialisasi'];
        $tanggal_lisensi = $_POST['Tanggal_Lisensi'];

        // Prepare and execute update query
        $stmt = $mysqli->prepare("UPDATE dokter SET Nama=?, Email=?, Jenis_Kelamin=?, Tanggal_Lahir=?, Alamat=?, NPI=?, No_Hp=?, Spesialisasi=?, Tanggal_Lisensi=? WHERE ID_Dokter=?");
        $stmt->bind_param("ssssssssss", $nama, $email, $jenis_kelamin, $tanggal_lahir, $alamat, $npi, $no_hp, $spesialisasi, $tanggal_lisensi, $id_dokter);

        if ($stmt->execute()) {
            echo "<script>alert('Data dokter berhasil diperbarui!'); window.location.href = 'mainDokter.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action === 'hapus') {
        // Retrieve ID_Dokter to delete
        $id_dokter = $_POST['ID_Dokter'];

        // Prepare and execute delete query
        $stmt = $mysqli->prepare("DELETE FROM dokter WHERE ID_Dokter=?");
        $stmt->bind_param("s", $id_dokter);

        if ($stmt->execute()) {
            echo "<script>alert('Data dokter berhasil dihapus!'); window.location.href = 'mainDokter.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$mysqli-> close();

function generateIdDokter($mysqli) {
    $prefix = "DPENSH";

    // Query to get the last ID_Dokter
    $result = $mysqli->query("SELECT ID_Dokter FROM dokter ORDER BY ID_Dokter DESC LIMIT 1");
    $lastDokter = $result->fetch_assoc();

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
?>