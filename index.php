<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header('Location: main.php'); // Redirect ke halaman utama jika sudah login
    exit;
}

// Konfigurasi database
$host = 'localhost';
$dbname = 'rekam_medis';
$dbuser = 'root'; 
$dbpass = ''; 

// Membuat koneksi ke database
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses login
$error = ""; // Inisialisasi variabel error
if (isset($_POST['username']) && isset($_POST['password'])) {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query untuk mengambil data pengguna berdasarkan username
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $inputUsername); // "s" = string
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password tanpa hashing
        if ($inputPassword === $user['password']) {
            $_SESSION['login'] = true;
            header('Location: main.php'); // Redirect ke halaman utama
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<?php include 'templates/header.php'; ?>

<!-- Main Content -->
<div class="container-fluid p-5 d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0">
        <div class="d-flex align-items-center mb-4">
            <img src="templates/img/Shield.png" alt="" class="me-2" style="width: 64px;">
            <h1 class="mb-0">PENS HOSPITAL</h1>
        </div>
        <!-- Left Section -->
        <div class="col-md-7 d-flex justify-content-center align-items-center gradient-bg">
            <div id="carouselExample" class="carousel slide carousel-fade p-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img
                            src="templates/img/DNA.png"
                            alt="DNA"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Medicine.png"
                            alt="Medicine"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Checklist.png"
                            alt="Checklist"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Hearth.png"
                            alt="Hearth"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                </div>
            </div>
        </div>



        <!-- Right Section -->
        <div class="col-md-5 d-flex align-items-center justify-content-center px-5">
            <div class="card card-login p-5 w-100 shadow-sm rounded-4">
                <h2 class="text-center mb-4">Login Admin</h2    >
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username </label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label remember-me-label" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="btn custom-btn text-white w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>