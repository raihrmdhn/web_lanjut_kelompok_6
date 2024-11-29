<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<?php
include 'koneksi.php'; // Ensure your PDO connection is in the 'koneksi.php' file

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':          
?>
  <div class="content-wrapper">
    <section class="content-header">
        <div class="col-3 mb-3">
            <h1>DOSEN</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="index.php?p=dosen&aksi=input" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Dosen
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="example1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nip</th>
                                        <th>Nama Dosen</th>
                                        <th>Email</th>
                                        <th>Prodi Id</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT dosen.*, prodi.id AS prodi_id 
                                                           FROM dosen 
                                                           JOIN prodi ON dosen.prodi_id = prodi.id");
                                    $stmt->execute();
                                    $no = 1;
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $data['nip'] ?></td>
                                        <td><?= $data['nama_dosen'] ?></td>
                                        <td><?= $data['email'] ?></td>
                                        <td><?= $data['prodi_id'] ?></td>
                                        <td><?= $data['notelp'] ?></td>
                                        <td><?= $data['alamat'] ?></td>
                                        <td>
                                            <a href="index.php?p=dosen&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                                                <i class="nav-icon fas fa-edit"></i> Edit
                                            </a>
                                            <a href="prosesDosen.php?proses=delete&id=<?= $data['id'] ?>" 
                                               class="btn btn-danger" 
                                               onclick="return confirm('Yakin akan menghapus data?')">
                                                <i class="nav-icon fas fa-ban"></i> Delete
                                            </a>   
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>

<?php
        break;
    case 'input' :            
?>
  <div class="content-wrapper">
    <section class="content-header">
        <div class="col-3 mb-3">
            <h1 class="h2">Input Dosen</h1>
        </div>
    </section>
    <section class="content">
        <form action="prosesDosen.php?proses=insert" method="post" class="mt-4">
            <div class="form-group row">
                <label for="nip" class="col-sm-4 col-form-label">NIP</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="nip" name="nip" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_dosen" class="col-sm-4 col-form-label">Nama Dosen</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="prodi_id" class="col-sm-4 col-form-label">Prodi</label>
                <div class="col-sm-8">
                    <select name="prodi_id" class="form-select" required>
                        <option value="">--Pilih Prodi--</option>
                        <?php
                        $queryProdi = $pdo->query("SELECT * FROM prodi");
                        while ($dataProdi = $queryProdi->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $dataProdi['id'] . "'>" . $dataProdi['nama_prodi'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="notelp" class="col-sm-4 col-form-label">No Telp</label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control" id="notelp" name="notelp" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>     
            </div>
        </form>
    </section>
  </div>

<?php
        break;
    case 'edit':
        // Get data for the record to be edited
        $stmt = $pdo->prepare("SELECT * FROM dosen WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        $data_dosen = $stmt->fetch(PDO::FETCH_ASSOC);
?>

  <div class="content-wrapper">
    <section class="content-header">
        <div class="col-3 mb-3">
            <h1 class="h2">Edit Dosen</h1>
        </div>
    </section>
    <section class="content">
        <form action="prosesDosen.php?proses=edit" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?= $data_dosen['id']?>">
            <div class="form-group row">
                <label for="nip" class="col-sm-4 col-form-label">NIP</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="nip" name="nip" value="<?= $data_dosen['nip']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_dosen" class="col-sm-4 col-form-label">Nama Dosen</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?= $data_dosen['nama_dosen']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="<?= $data_dosen['email']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="prodi_id" class="col-sm-4 col-form-label">Prodi</label>
                <div class="col-sm-8">
                    <select name="prodi_id" class="form-select">
                        <option value="">--Pilih Prodi--</option>
                        <?php
                        $queryProdi = $pdo->query("SELECT * FROM prodi");
                        while ($dataProdi = $queryProdi->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($dataProdi['id'] == $data_dosen['prodi_id']) ? "selected" : "";
                            echo "<option value='" . $dataProdi['id'] . "' $selected>" . $dataProdi['nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="notelp" class="col-sm-4 col-form-label">No Telp</label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control" id="notelp" name="notelp" value="<?= $data_dosen['notelp']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $data_dosen['alamat'] ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>     
            </div>
        </form>
    </section>
  </div>

<?php
        break;
}
?>
</html>
