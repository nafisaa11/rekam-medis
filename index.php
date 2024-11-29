<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
        }

        .sidebar {
            background: linear-gradient(to bottom, #2196f3, #1976d2);
            color: white;
            min-height: 100vh;
        }

        .sidebar .admin-image {
            width: 100px;
            height: 100px;
            border: 3px solid white;
        }

        .sidebar h3 {
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
        }

        .menu-item {
            transition: all 0.3s;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }

        .menu-item i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .logout-btn {
            background: white;
            color: #1976d2;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column align-items-center p-4">
            <!-- Admin Profile -->
            <div class="d-flex flex-column align-items-center">
                <img src="img/gojo.png" alt="Admin Image" class="admin-image rounded-circle shadow">
                <h3 class="mt-3">Admin 1</h3>
            </div>

            <!-- Menu -->
            <div class="mt-5 w-100">
                <div class="menu-item text-white d-flex align-items-center">
                    <i class="fa-solid fa-file-medical"></i>
                    <span>Data Pasien</span>
                </div>
                <div class="menu-item text-white d-flex align-items-center mt-3">
                    <i class="fa-solid fa-user-md"></i>
                    <a href="Rekam_medis/mainDokter" class="text-decoration-none text-white w-100">Data Dokter</a>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="position-absolute bottom-0 mb-3">
                <a href="Rekam_medis" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <img src="img/Shield.png" alt="Shield Logo" class="me-3" style="width: 60px; height: auto;">
        <h2 class="fw-bold text-primary mb-0">PENS HOSPITAL</h2>
    </div>

    <div class="content my-4 d-flex justify-content-center">
        <div class="w-100 bg-light rounded-4 p-4 shadow-sm">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-secondary">DATA PASIEN</h3>
                <form class="d-flex align-items-center" action="#" method="post">
                    <input type="text" class="form-control shadow-sm me-2" placeholder="Cari Pasien..." style="max-width: 300px;" />
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID Pasien</th>
                            <th>Nama Pasien</th>
                            <th>Nama Ibu</th>
                            <th>Tgl. Lahir</th>
                            <th>No. Telp</th>
                            <th>Lihat Rekam Medis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dummy data -->
                        <tr>
                            <td>001</td>
                            <td>John Doe</td>
                            <td>Jane Doe</td>
                            <td>1990-01-01</td>
                            <td>081234567890</td>
                            <td>
                                <a href="#" class="text-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Mary Jane</td>
                            <td>Sarah Jane</td>
                            <td>1985-05-15</td>
                            <td>081298765432</td>
                            <td>
                                <a href="#" class="text-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data pasien tidak tersedia.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="d-flex justify-content-end mt-4">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</body>

</html>