<?php
// Database connection
$host = 'localhost';
$dbname = 'rekam_medis';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Search functionality
    $searchQuery = "";
    $searchTerm = "";
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = "%" . $_GET['search'] . "%";
        $searchQuery = "WHERE ID_Dokter LIKE :searchTerm 
                        OR Nama LIKE :searchTerm 
                        OR Spesialisasi LIKE :searchTerm 
                        OR Alamat LIKE :searchTerm 
                        OR No_Hp LIKE :searchTerm";
    }

    // Pagination variables
    $itemsPerPage = 5; // Jumlah data per halaman
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Query total items
    $totalItemsQuery = "SELECT COUNT(*) FROM dokter $searchQuery";
    $stmt = $pdo->prepare($totalItemsQuery);
    if (!empty($searchQuery)) {
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();
    $totalItems = $stmt->fetchColumn();
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Query paginated data
    $dataQuery = "SELECT * FROM dokter $searchQuery LIMIT :offset, :itemsPerPage";
    $stmt = $pdo->prepare($dataQuery);
    if (!empty($searchQuery)) {
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
