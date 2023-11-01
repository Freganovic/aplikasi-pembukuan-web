<h3>Dashboard</h3>
<br />
<?php
// Query untuk mengecek stok barang yang kurang dari atau sama dengan 3
$sql = "SELECT * FROM barang WHERE stok <= 3";
$row = $config->prepare($sql);
$row->execute();
$r = $row->rowCount();

if ($r > 0) {
    echo "
    <div class='alert alert-warning'>
        <span class='glyphicon glyphicon-info-sign'></span> Ada <span style='color:red'>$r</span> barang yang Stok tersisa sudah kurang dari 3 items. Silahkan pesan lagi !!
        <span class='pull-right'><a href='index.php?page=barang&stok=yes'>Tabel Barang <i class='fa fa-angle-double-right'></i></a></span>
    </div>
    ";
}


$hasil_barang = $lihat->barang_row();
$hasil_kategori = $lihat->kategori_row();
$stok = $lihat->barang_stok_row();
$jual = $lihat->jual_row();

$bayar = 0; // Total pendapatan
$modal = 0; // Total modal
$jumlah = 0; // Jumlah barang terjual

if (!empty($_GET['cari'])) {
    $periode = $_POST['bln'] . '-' . $_POST['thn'];
    $hasil = $lihat->periode_jual($periode);
} elseif (!empty($_GET['hari'])) {
    $hari = $_POST['hari'];
    $hasil = $lihat->hari_jual($hari);
} else {
    $hasil = $lihat->jual();
}

foreach ($hasil as $isi) {
    $bayar += $isi['total'];
    $modal += $isi['harga_beli'] * $isi['jumlah'];
    $jumlah += $isi['jumlah'];
}
?>

<div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-cubes"></i> Jumlah Barang</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo number_format($hasil_barang); ?></h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=barang'>Tabel Barang <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-upload"></i> Telah Terjual</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo number_format($jual['stok']); ?></h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=laporan'>Tabel Laporan <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-cubes"></i> Jumlah Mitra</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>
                        <?php
                        $host = "localhost"; // Ganti dengan host database Anda
                        $username = "root"; // Ganti dengan username database Anda
                        $password = ""; // Ganti dengan kata sandi database Anda
                        $database = "db_toko"; // Ganti dengan nama database Anda

                        $koneksi = new mysqli($host, $username, $password, $database);

                        if ($koneksi->connect_error) {
                            die("Koneksi database gagal: " . $koneksi->connect_error);
                        }

                        $query = "SELECT COUNT(*) AS total_mitra FROM pemitra";
                        $result = $koneksi->query($query);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_mitra = $row['total_mitra'];
                        } else {
                            $total_mitra = 0;
                        }

                        $koneksi->close();
                        echo number_format($total_mitra);
                        ?>
                    </h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=pemitra'>Tabel Mitra <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-5 mb-5">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5 class="card-title"><strong>OMSET PENJUALAN BULAN INI</strong></h5>
                <?php
                $keuntungan = $bayar - $modal;
                ?>
                <h4 class="display-5 text-white">
                    Rp. <?php echo number_format($keuntungan); ?>,-
                </h4>
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
    </div>
</div>