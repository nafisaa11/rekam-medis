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
                <div class="flex-grow-1 p-4">
            <div class="bg-white p-5 shadow rounded">
                <h1>Welcome to Admin Dashboard</h1>
                <p class="text-muted">Manage your data efficiently with our tools.</p>
            </div>

            <!-- Tabel Pasien -->
            <div class="bg-white p-5 mt-4 shadow rounded">
                <h2>Data Pasien</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh Data Pasien -->
                            <tr>
                                <td>001</td>
                                <td>Ahmad Fauzi</td>
                                <td>30</td>
                                <td>Laki-laki</td>
                                <td>Jl. Merdeka No. 123</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>Siti Nurhaliza</td>
                                <td>28</td>
                                <td>Perempuan</td>
                                <td>Jl. Sudirman No. 45</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                            <!-- Data Lainnya Bisa Ditambahkan Secara Dinamis -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>
