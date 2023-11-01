<?php
// Pastikan file ini diakses melalui permintaan POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir tambah mitra
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $cup_jumbo = $_POST['cup_jumbo'];
    $cup_sedang = $_POST['cup_sedang'];
    $teh_sehatie = $_POST['teh_sehatie'];
    $nominal = $_POST['nominal'];

    // Validasi data jika diperlukan
    // Misalnya, pastikan semua data telah diisi dengan benar

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

    // Query SQL untuk menambahkan data mitra
    $query = "INSERT INTO mitra (tanggal, nama, cup_jumbo, cup_sedang, teh_sehatie, nominal) VALUES ('$tanggal', '$nama', $cup_jumbo, $cup_sedang, $teh_sehatie, $nominal)";

    if ($koneksi->query($query) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    // Menutup koneksi database
    $koneksi->close();
}
