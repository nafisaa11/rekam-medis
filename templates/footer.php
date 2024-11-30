    <footer class="text-white py-1 fixed-bottom text-center" style="background: #1976d2;">
        <p class="p-0 m-0">PENS Hospital &copy; 2024</p>
    </footer>
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
      integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
      integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
      crossorigin="anonymous"
    ></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <!-- Script buat Modal Edit Dokter -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
     <script>
      document.addEventListener("DOMContentLoaded", function () {
      // Tambahkan event listener pada tombol edit dokter
      document.querySelectorAll(".btn-edit-dokter").forEach((button) => {
        button.addEventListener("click", function () {
          const dokterId = this.dataset.id; // Ambil ID dokter dari data-id atribut

          // Ambil data dokter dari API
          fetch(`http://202.10.36.253:3001/api/dokter/${dokterId}`)
            .then((response) => response.json())
            .then((data) => {
              // Isi modal dengan data dokter
              document.getElementById("edit_id_dokter").value = data.ID_Dokter;
              document.getElementById("edit_nama").value = data.Nama;
              document.getElementById("edit_email").value = data.Email;
              document.getElementById("edit_npi").value = data.NPI;
              document.getElementById("edit_no-hp").value = data.No_Hp;
              document.getElementById("edit_alamat").value = data.Alamat;
              document.getElementById("edit_spesialisasi").value = data.Spesialisasi;
              document.getElementById("edit_tanggal-lisensi").value = data.Tanggal_Lisensi;
              document.getElementById("edit_tanggal-lahir").value = data.Tanggal_Lahir;

              // Set gender radio button
              document.querySelector(
                `input[name="Jenis_Kelamin"][value="${data.Jenis_Kelamin}"]`
              ).checked = true;
            })
            .catch((error) => {
              console.error("Error fetching dokter data:", error);
              alert("Gagal memuat data dokter.");
            });
        });
      });
    });


     </script>
  </body>
</html>
