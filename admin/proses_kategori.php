<?php
include 'koneksi.php';

$proses = $_GET['proses'];

try {
    switch ($proses) {
        case 'insert':
            $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori, keterangan) VALUES (?, ?)");
            $stmt->execute([
                $_POST['nama_kategori'],
                $_POST['keterangan']
            ]);
            header("location: index.php?p=kategori&alert=success&message=Data berhasil ditambahkan");
            break;

        case 'edit':
            $stmt = $pdo->prepare("UPDATE kategori SET nama_kategori = ?, keterangan = ? WHERE id = ?");
            $stmt->execute([
                $_POST['nama_kategori'],
                $_POST['keterangan'],
                $_POST['id']
            ]);
            header("location: index.php?p=kategori&alert=success&message=Data berhasil diupdate");
            break;

        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM kategori WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            header("location: index.php?p=kategori&alert=success&message=Data berhasil dihapus");
            break;
    }
} catch(PDOException $e) {
    header("location: index.php?p=kategori&alert=error&message=" . urlencode($e->getMessage()));
}
?>