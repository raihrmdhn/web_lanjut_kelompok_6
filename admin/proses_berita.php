<?php 
include 'koneksi.php'; // Menggunakan koneksi dari file koneksi.php
session_start();

$target_dir = "uploads/";

// Insert Data
if (isset($_GET['proses']) && $_GET['proses'] == 'insert') {

    $nama_file = rand() . '-' . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $nama_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita) VALUES (:user_id, :kategori_id, :judul, :file_upload, :isi_berita)");
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
                $stmt->bindParam(':judul', $_POST['judul']);
                $stmt->bindParam(':file_upload', $nama_file);
                $stmt->bindParam(':isi_berita', $_POST['isi_berita']);
                $stmt->execute();

                echo "<script>window.location='index.php?p=berita'</script>";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Edit Data
if (isset($_GET['proses']) && $_GET['proses'] == 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi_berita = $_POST['isi_berita'];
    $file_upload = null;

    if (!empty($_FILES['fileToUpload']['name'])) {
        $nama_file = rand() . '-' . basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $nama_file;
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $file_upload = $nama_file;
        }
    }

    try {
        if ($file_upload) {
            $query = "UPDATE berita SET judul=:judul, kategori_id=:kategori_id, file_upload=:file_upload, isi_berita=:isi_berita WHERE id=:id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':file_upload', $file_upload);
        } else {
            $query = "UPDATE berita SET judul=:judul, kategori_id=:kategori_id, isi_berita=:isi_berita WHERE id=:id";
            $stmt = $pdo->prepare($query);
        }
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':kategori_id', $kategori_id);
        $stmt->bindParam(':isi_berita', $isi_berita);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: index.php?p=berita'); 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Delete Data
if (isset($_GET['proses']) && $_GET['proses'] == 'delete') {
    $file_path = $target_dir . $_GET['file'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM berita WHERE id=:id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php?p=berita');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
