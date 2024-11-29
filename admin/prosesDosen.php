<?php
include 'koneksi.php';

if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];

  
    if ($proses == 'insert') {
        try {
            $sql = $pdo->prepare("INSERT INTO dosen (nip, nama_dosen, email, prodi_id, notelp, alamat) 
                                  VALUES (:nip, :nama_dosen, :email, :prodi_id, :notelp, :alamat)");

           
            $sql->bindParam(':nip', $_POST['nip']);
            $sql->bindParam(':nama_dosen', $_POST['nama_dosen']);
            $sql->bindParam(':email', $_POST['email']);
            $sql->bindParam(':prodi_id', $_POST['prodi_id']);
            $sql->bindParam(':notelp', $_POST['notelp']);
            $sql->bindParam(':alamat', $_POST['alamat']);

         
            $sql->execute();
            echo "<script>window.location='index.php?p=dosen'</script>";
        } catch (PDOException $e) {
            die("Error saat menambahkan data: " . $e->getMessage());
        }
    }


    if ($proses == 'edit') {
        try {
            $sql = $pdo->prepare("UPDATE dosen SET
                                  nip = :nip,
                                  nama_dosen = :nama_dosen,
                                  email = :email,
                                  prodi_id = :prodi_id,
                                  notelp = :notelp,
                                  alamat = :alamat
                                  WHERE id = :id");

         
            $sql->bindParam(':nip', $_POST['nip']);
            $sql->bindParam(':nama_dosen', $_POST['nama_dosen']);
            $sql->bindParam(':email', $_POST['email']);
            $sql->bindParam(':prodi_id', $_POST['prodi_id']);
            $sql->bindParam(':notelp', $_POST['notelp']);
            $sql->bindParam(':alamat', $_POST['alamat']);
            $sql->bindParam(':id', $_POST['id'], PDO::PARAM_INT);

         
            $sql->execute();
            echo "<script> window.location='index.php?p=dosen';</script>";
        } catch (PDOException $e) {
            die("Error saat memperbarui data: " . $e->getMessage());
        }
    }

    if ($proses == 'delete') {
        try {
            $sql = $pdo->prepare("DELETE FROM dosen WHERE id = :id");

           
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

           
            $sql->execute();
            echo "<script> window.location='index.php?p=dosen';</script>";
        } catch (PDOException $e) {
            die("Error saat menghapus data: " . $e->getMessage());
        }
    }
} else {
    echo "Proses tidak ditemukan!";
}
?>
