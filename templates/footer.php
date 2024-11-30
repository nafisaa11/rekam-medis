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
      $(document).on('click', '.editDokterBtn', function() {
    var id_dokter = $(this).data('id'); // Ambil ID Dokter dari atribut data-id

    $.ajax({
        url: "../controllers/editDokter.php", // URL untuk mengambil data dokter
        method: "POST",
        data: { id_dokter: id_dokter }, // Kirim ID dokter ke server
        dataType: "json", // Format data yang diharapkan dari server
        success: function(data) {
            if (data) {
                // Isi data ke dalam form modal
                $('#edit-id').val(data.ID_Dokter);
                $('#edit-nama').val(data.Nama);
                $('#edit-email').val(data.Email);
                $('#edit-telepon').val(data.No_Hp);
                $('#edit-tgl_lahir').val(data.Tanggal_Lahir);
                $('#edit-npi').val(data.NPI);
                $('#edit-spesialisasi').val(data.Spesialisasi);
                $('#edit-tanggal-lisensi').val(data.Tanggal_Lisensi);

                // Tampilkan modal
                $('#editDokterModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan: " + error);
        }
    });
});




     </script>
  </body>
</html>
