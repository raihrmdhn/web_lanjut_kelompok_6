<?php
include 'koneksi.php';

try {
    $proses = $_GET['proses'];
    
    switch ($proses) {
        case 'insert':
            if (isset($_POST['submit'])) {
                // Validasi input
                if (empty($_POST['nim']) || empty($_POST['nama'])) {
                    throw new Exception("NIM dan Nama harus diisi!");
                }
                

                $tgl_lahir = $_POST['thn'] . "-" . $_POST['bln'] . "-" . $_POST['tgl'];
                
                $hobi = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
                
                $stmt = $pdo->prepare("INSERT INTO mahasiswa (nim, nama, tgl_lahir, jenis_kelamin, hobi, email, no_telp, alamat) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                    
                if ($stmt->execute([
                    $_POST['nim'],
                    $_POST['nama_mhs'],
                    $tgl_lahir,
                    $_POST['jekel'],
                    $hobi,
                    $_POST['email'],
                    $_POST['notelp'],
                    $_POST['alamat']
                ])) {
                    echo "<script>alert('Data Berhasil Ditambahkan'); window.location.href='index.php?p=mhs';</script>";
                }
            }
            break;
            
        case 'edit':
            if (isset($_POST['submit'])) {
                // Format tanggal
                $tgl_lahir = $_POST['thn'] . "-" . $_POST['bln'] . "-" . $_POST['tgl'];
                
                // Format hobi dengan pengecekan yang lebih baik
                $hobi = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
                
                try {
                    $stmt = $pdo->prepare("UPDATE mahasiswa SET 
                                        nama_mhs = ?, 
                                        tgl_lahir = ?, 
                                        jekel = ?, 
                                        hobi = ?, 
                                        email = ?, 
                                        notelp = ?, 
                                        alamat = ? 
                                        WHERE nim = ?");
                                        
                    if ($stmt->execute([
                        $_POST['nama_mhs'],
                        $tgl_lahir,
                        $_POST['jekel'],
                        $hobi,
                        $_POST['email'],
                        $_POST['notelp'],
                        $_POST['alamat'],
                        $_POST['nim']
                    ])) {
                        echo "<script>alert('Data Berhasil Diupdate'); window.location.href='index.php?p=mhs';</script>";
                    }
                } catch(PDOException $e) {
                    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='index.php?p=mhs';</script>";
                }
            }
            break;
            
        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE nim = ?");
            if ($stmt->execute([$_GET['nim']])) {
                echo "<script>alert('Data Berhasil Dihapus'); window.location.href='index.php?p=mhs';</script>";
            }
            break;
    }
} catch(PDOException $e) {
    echo "<script>alert('Error Database: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='index.php?p=mhs';</script>";
} catch(Exception $e) {
    echo "<script>alert('" . htmlspecialchars($e->getMessage()) . "'); window.location.href='index.php?p=mhs';</script>";
}
?>