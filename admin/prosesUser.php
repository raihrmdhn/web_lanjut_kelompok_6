<?php
include 'koneksi.php';

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses === 'insert') {
   
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $notelp = htmlspecialchars($_POST['notelp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $photo = '';

    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "upload/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo = uniqid() . '.' . $file_extension; 
        $target_file = $target_dir . $photo;
        
    
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_extension), $allowed_types)) {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        } else {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }

    try {
        $query = "INSERT INTO user (email, password, level, nama_lengkap, notelp, photo, alamat) 
                  VALUES (:email, :password, :level, :nama_lengkap, :notelp, :photo, :alamat)";
        $stmt = $pdo->prepare($query);
        
   
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt->bindParam(':notelp', $notelp);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':alamat', $alamat);
        

        $stmt->execute();
        
        header("Location: index.php?p=user&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} elseif ($proses === 'edit') {

    $id = $_POST['id'];
    $email = htmlspecialchars($_POST['email']);
    $level = $_POST['level'];
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $notelp = htmlspecialchars($_POST['notelp']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $query = "UPDATE user SET 
              email = :email,
              level = :level,
              nama_lengkap = :nama_lengkap,
              notelp = :notelp,
              alamat = :alamat";


    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query .= ", password = :password";
    }


    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "upload/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $photo;
        

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_extension), $allowed_types)) {
       
            $old_photo_query = $pdo->prepare("SELECT photo FROM user WHERE id = :id");
            $old_photo_query->bindParam(':id', $id);
            $old_photo_query->execute();
            $old_photo = $old_photo_query->fetch(PDO::FETCH_ASSOC);
            if ($old_photo['photo'] && file_exists("upload/" . $old_photo['photo'])) {
                unlink("upload/" . $old_photo['photo']);
            }
            
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
            $query .= ", photo = :photo";
        } else {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }


    $query .= " WHERE id = :id";

    try {
        $stmt = $pdo->prepare($query);

       
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt->bindParam(':notelp', $notelp);
        $stmt->bindParam(':alamat', $alamat);
        if (!empty($_POST['password'])) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':id', $id);

        if (isset($photo)) {
            $stmt->bindParam(':photo', $photo);
        }
        
        
        $stmt->execute();
        
        header("Location: index.php?p=user&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} elseif ($proses === 'delete') {
    $id = $_GET['id'];
    $photo = $_GET['photo'];
    
   
    if ($photo && file_exists("upload/" . $photo)) {
        unlink("upload/" . $photo);
    }
    
 
    try {
        $query = "DELETE FROM user WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        header("Location: index.php?p=user&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
