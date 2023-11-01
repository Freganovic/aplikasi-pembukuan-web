<h1>DATA PEMITRA</h1>
<!-- view pemitra -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                    <tr style="background: #ADD8E6; color: #333;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal Join</th>
                        <th>Lokasi</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Konfigurasi koneksi database
                    $host = "localhost"; // Ganti dengan host database Anda
                    $username = "root"; // Ganti dengan username database Anda
                    $password = ""; // Ganti dengan kata sandi database Anda
                    $database = "db_toko"; // Ganti dengan nama database Anda

                    // Membuat koneksi ke database
                    $koneksi = new mysqli($host, $username, $password, $database);

                    // Memeriksa koneksi
                    if ($koneksi->connect_error) {
                        die("Koneksi database gagal: " . $koneksi->connect_error);
                    }

                    // Query untuk mengambil data dari tabel "pemitra"
                    $query = "SELECT * FROM pemitra"; // Query SQL di sini
                    $result = $koneksi->query($query);

                    if ($result) {
                        $no = 1;

                        // Mengambil data dari hasil query
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['alamat']; ?></td>
                                <td><?php echo $row['tanggal_join']; ?></td>
                                <td><?php echo $row['lokasi']; ?></td>
                                <td><?php echo $row['telepon']; ?></td>
                            </tr>
                    <?php
                            $no++;
                        }
                    } else {
                        echo "Gagal mengambil data dari database.";
                    }

                    // Menutup koneksi database
                    $koneksi->close();
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tombol Tambah Data -->
<button type="button" class="btn btn-primary" id="btn-tambah-data" data-toggle="modal" data-target="#tambahDataModal">
    Tambah Data
</button>

<!-- Modal untuk Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-pemitra">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_join">Tanggal Join</label>
                        <input type="date" class="form-control" id="tanggal_join" name="tanggal_join" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi Booth</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-pemitra">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tangani pengiriman data mitra saat tombol "Simpan" di modal ditekan
        $('#btn-simpan-pemitra').click(function() {
            // Validasi input data mitra di sini jika diperlukan
            var dataPemitra = {
                nama: $('#nama').val(),
                alamat: $('#alamat').val(),
                tanggal_join: $('#tanggal_join').val(),
                lokasi: $('#lokasi').val(),
                telepon: $('#telepon').val()
            };

            // Kirim data mitra menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: 'alat/proses_tambah_pemitra.php',
                data: dataPemitra,
                success: function(response) {
                    if (response === 'success') {
                        // Data berhasil ditambahkan, lakukan sesuatu jika diperlukan
                        alert('Data mitra berhasil disimpan');
                        $('#tambahDataModal').modal('hide'); // Tutup modal
                        location.reload(); // Mereset halaman

                        // Tambahkan kode lain yang perlu dijalankan setelah data disimpan
                    } else {
                        // Menampilkan pesan kesalahan jika ada masalah
                        alert('Gagal menyimpan data : ' + response);
                    }
                }
            });
        });
    });
</script>