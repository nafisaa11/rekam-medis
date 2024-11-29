      <?php include 'templates/header.php';?>
      
      <!-- Main Content -->
      <main class="flex-1 px-4 py-4">
        <div class="d-flex align-items-center mb-4">
          <img
            src="templates/img/Shield.png"
            alt="Shield Logo"
            class="me-3"
            style="width: 60px; height: auto"
          />
          <h2 class="fw-bold text-primary mb-0">PENS HOSPITAL</h2>
        </div>

        <div class="content my-4 d-flex justify-content-center">
          <div class="w-100 bg-light rounded-4 p-4 shadow-sm">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 class="fw-bold text-secondary">DATA PASIEN</h3>
              <form class="d-flex align-items-center" action="#" method="post">
                <input
                  type="text"
                  class="form-control shadow-sm me-2"
                  placeholder="Cari Pasien..."
                  style="max-width: 300px"
                />
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
                    <td colspan="6" class="text-center text-muted">
                      Data pasien tidak tersedia.
                    </td>
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

<?php include 'templates/footer.php';?>