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
// Include the PDO connection file
include 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="col-3 mb-3">
            <h1>PRODI</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="index.php?p=prodi&aksi=input" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Prodi
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
                                        <th>nama_prodi Prodi</th>
                                        <th>Jenjang jenjang_prodi</th>
                                        <th>Aksi</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch data using PDO
                                    $stmt = $pdo->query("SELECT * FROM prodi");
                                    $no = 1;
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                                            <td><?= htmlspecialchars($data['jenjang_prodi']) ?></td>
                                            <td>
                                                <a href="index.php?p=prodi&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                <a href="prosesProdi.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin akan menghapus data?')"><i class="nav-icon fas fa-ban"></i> Delete</a>   
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

    case 'input':
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="col-3 mb-3">
            <h1 class="h2">Input Prodi</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form action="prosesProdi.php?proses=insert" method="post">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">nama_prodi Prodi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama_prodi">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jenjang jenjang_prodi</label>
                    <div class="col-sm-10">
                        <select id="jenjang_prodi" name="jenjang_prodi" class="form-control" required>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                        </select>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                        <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<?php
    break;

    case 'edit':
        // Fetch data for edit using PDO
        $stmt = $pdo->prepare("SELECT * FROM prodi WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h2">Edit Prodi</h1>
    </section>
    <section class="content">
        <div class="container">
            <form action="prosesProdi.php?proses=edit" method="post">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">nama_prodi Prodi</label>
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                        <input type="text" class="form-control" name="nama_prodi" value="<?= htmlspecialchars($data['nama_prodi']) ?>">
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jenjang jenjang_prodi</label>
                    <div class="col-sm-10">
                        <select id="jenjang_prodi" name="jenjang_prodi" class="form-control" required>
                            <option value="D3" <?= $data['jenjang_prodi'] == 'D3' ? 'selected' : '' ?>>D3</option>
                            <option value="D4" <?= $data['jenjang_prodi'] == 'D4' ? 'selected' : '' ?>>D4</option>
                        </select>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<?php
    break;
}
?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    const input = document.getElementById('file-upload');
    const previewPhoto = () => {
        const file = input.files;
        if (file) {
            const fileReader = new FileReader();
            const preview = document.getElementById('file-preview');
            fileReader.onload = function (event) {
                preview.setAttribute('src', event.target.result);
            }
            fileReader.readAsDataURL(file[0]);
        }
    }
    input.addEventListener("change", previewPhoto);
</script>
</body>
</html>
