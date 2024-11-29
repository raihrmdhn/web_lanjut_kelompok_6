<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    try {
        $stmt = $pdo->prepare("INSERT INTO level (nama_level, keterangan) VALUES (?, ?)");
        $stmt->execute([
            $_POST['nama_level'],
            $_POST['keterangan']
        ]);
        
        echo "<script>window.location='index.php?p=level'</script>";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'edit') {
    try {
        $stmt = $pdo->prepare("UPDATE level SET nama_level = ?, keterangan = ? WHERE id = ?");
        $stmt->execute([
            $_POST['nama_level'],
            $_POST['keterangan'],
            $_POST['id']
        ]);
        
        echo "<script>window.location='index.php?p=level'</script>";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $pdo->prepare("DELETE FROM level WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        
        header('location:index.php?p=level');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>