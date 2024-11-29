<?php
include 'koneksi.php';

if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];

    try {
        if ($proses == 'insert') {
            $sql = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, semester, jenis_matakuliah, sks, jam, keterangan) 
                    VALUES (:kode, :nama, :semester, :jenis, :sks, :jam, :ket)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':kode' => $_POST['kode_matakuliah'],
                ':nama' => $_POST['nama_matakuliah'],
                ':semester' => $_POST['semester'],
                ':jenis' => $_POST['jenis_matakuliah'],
                ':sks' => $_POST['sks'],
                ':jam' => $_POST['jam'],
                ':ket' => $_POST['keterangan']
            ]);

            header('Location: index.php?p=matakuliah&pesan=Data berhasil ditambahkan');
            exit;
        } 

        elseif ($proses == 'edit') {
            $sql = "UPDATE matakuliah SET 
                    kode_matakuliah = :kode,
                    nama_matakuliah = :nama,
                    semester = :semester,
                    jenis_matakuliah = :jenis,
                    sks = :sks,
                    jam = :jam,
                    keterangan = :ket
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':kode' => $_POST['kode_matakuliah'],
                ':nama' => $_POST['nama_matakuliah'],
                ':semester' => $_POST['semester'],
                ':jenis' => $_POST['jenis_matakuliah'],
                ':sks' => $_POST['sks'],
                ':jam' => $_POST['jam'],
                ':ket' => $_POST['keterangan'],
                ':id' => $_POST['id']
            ]);

            header('Location: index.php?p=matakuliah&pesan=Data berhasil diperbarui');
            exit;
        } 

        elseif ($proses == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM matakuliah WHERE id = ?");
            $stmt->execute([$_GET['id']]);

            header('Location: index.php?p=matakuliah&pesan=Data berhasil dihapus');
            exit;
        }
    } catch(PDOException $e) {
        header('Location: index.php?p=matakuliah&pesan=Error: ' . $e->getMessage());
        exit;
    }
}
?>
