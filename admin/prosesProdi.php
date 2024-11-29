<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    try {
        $stmt = $pdo->prepare("INSERT INTO prodi (nama_prodi, jenjang_prodi) VALUES (:nama_prodi, :jenjang_prodi)");
        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_prodi', $_POST['jenjang_prodi']);
        $stmt->execute();

        if ($stmt) {
            echo "<script>window.location='index.php?p=prodi'</script>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

if ($_GET['proses'] == 'edit') {
    try {
        $stmt = $pdo->prepare("UPDATE prodi SET nama_prodi = :nama_prodi, jenjang_prodi = :jenjang_prodi WHERE id = :id");
        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_prodi', $_POST['jenjang_prodi']);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        if ($stmt) {
            echo "<script>window.location='index.php?p=prodi'</script>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $pdo->prepare("DELETE FROM prodi WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        if ($stmt) {
            header('location:index.php?p=prodi'); // Redirect
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
