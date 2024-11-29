<?php
// Database connection using PDO
$host = 'localhost'; // your database host
$dbname = 'db_tekom2a'; // your database name
$username = 'root'; // your database username
$password = ''; // your database password

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_GET['proses'] == 'insert') {
    // Insert operation using PDO
    $sql = "INSERT INTO prodi (nama_prodi, jenjang_prodi) VALUES (:nama_prodi, :jenjang_prodi)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
    $stmt->bindParam(':jenjang_prodi', $_POST['jenjang_prodi']);

    if ($stmt->execute()) {
        echo "<script>window.location='index.php?p=prodi'</script>";
    } else {
        echo "Error: Unable to insert data.";
    }
}

if ($_GET['proses'] == 'edit') {
    // Edit operation using PDO
    $sql = "UPDATE prodi SET nama_prodi = :nama_prodi, jenjang_prodi = :jenjang_prodi WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
    $stmt->bindParam(':jenjang_prodi', $_POST['jenjang_prodi']);
    $stmt->bindParam(':id', $_POST['id']);

    if ($stmt->execute()) {
        echo "<script>window.location='index.php?p=prodi'</script>";
    } else {
        echo "Error: Unable to update data.";
    }
}

if ($_GET['proses'] == 'delete') {
    // Delete operation using PDO
    $sql = "DELETE FROM prodi WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);

    if ($stmt->execute()) {
        header('location:index.php?p=prodi'); //redirect
    } else {
        echo "Error: Unable to delete data.";
    }
}
?>
