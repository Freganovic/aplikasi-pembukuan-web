<h1>DATA BELANJA MITRA</h1>
<!-- view mitra -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                    <tr style="background: #ADD8E6; color: #333;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th style="width:10%;">Cup Jumbo</th>
                        <th style="width:10%;">Cup Sedang</th>
                        <th style="width:10%;">Teh Sehatie</th>
                        <th style="width:10%;">Nominal</th>
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

                    // Query untuk mengambil data dari tabel "mitra"
                    $query = "SELECT * FROM mitra"; // Query SQL di sini
                    $result = $koneksi->query($query);

                    if ($result) {
                        $no = 1;
                        $total_pemasukan = 0;
                        $total_pengeluaran = 0;
                        $total_total = 0;

                        // Mengambil data dari hasil query
                        while ($row = $result->fetch_assoc()) {
                            $total_pemasukan += $row['cup_jumbo'];
                            $total_pengeluaran += $row['cup_sedang'];
                            $total_total += $row['teh_sehatie'];
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['tanggal']; ?></td>
                                <td><?php echo number_format($row['cup_jumbo'],); ?></td>
                                <td><?php echo number_format($row['cup_sedang'],); ?></td>
                                <td><?php echo number_format($row['teh_sehatie'],); ?></td>
                                <td>Rp.<?php echo number_format($row['nominal'], 3); ?>,-</td>
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
                <form id="form-tambah-mitra">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="cup_jumbo">Cup Jumbo</label>
                        <input type="text" class="form-control" id="cup_jumbo" name="cup_jumbo" required>
                    </div>
                    <div class="form-group">
                        <label for="cup_sedang">Cup Sedang</label>
                        <input type="text" class="form-control" id="cup_sedang" name="cup_sedang" required>
                    </div>
                    <div class="form-group">
                        <label for="teh_sehatie">Teh Sehatie</label>
                        <input type="text" class="form-control" id="teh_sehatie" name="teh_sehatie" required>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-mitra">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Tangani pengiriman data mitra saat tombol "Simpan" di modal ditekan
        $('#btn-simpan-mitra').click(function() {
            // Validasi input data mitra di sini jika diperlukan
            var dataMitra = {
                tanggal: $('#tanggal').val(),
                nama: $('#nama').val(),
                cup_jumbo: $('#cup_jumbo').val(),
                cup_sedang: $('#cup_sedang').val(),
                teh_sehatie: $('#teh_sehatie').val(),
                nominal: $('#nominal').val()
            };

            // Kirim data mitra menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: 'alat/proses_tambah_mitra.php',
                data: dataMitra,
                success: function(response) {
                    if (response === 'success') {
                        // Data berhasil ditambahkan, lakukan sesuatu jika diperlukan
                        alert('Data mitra berhasil disimpan');
                        $('#tambahDataModal').modal('hide'); // Tutup modal
                        location.reload(); // Mereset halaman

                        // Tambahkan kode lain yang perlu dijalankan setelah data disimpan
                    } else {
                        // Menampilkan pesan kesalahan jika ada masalah
                        alert('Gagal menyimpan data mitra: ' + response);
                    }
                }
            });
        });
    });
</script>