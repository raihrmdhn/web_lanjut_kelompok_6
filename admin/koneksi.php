<?php
// Setel variabel koneksi database
$host = 'localhost';  // Host database
$dbname = 'db_tekom2a';  // Nama database
$username = 'root';   // Username MySQL (biasanya 'root' di XAMPP)
$password = '';       // Password MySQL (kosong di XAMPP)

// Membuat koneksi PDO
try {
    // Membuat objek PDO untuk koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Mengatur mode kesalahan PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Menangani jika terjadi kesalahan koneksi
    echo "Koneksi gagal: " . $e->getMessage();
    exit();
}
?>