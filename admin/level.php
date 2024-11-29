<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h2>Data Level</h2>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col-2">
                        <a href="index.php?p=level&aksi=input" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Level
                        </a>
                    </div>
                </div>
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Level</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM level");
                            $no = 1;
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($data['nama_level']) ?></td>
                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            <td>
                                <a href="index.php?p=level&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="proses_level.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php 
                                $no++; 
                            }
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "pageLength": 10,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>

<style>
.table-responsive {
    margin: 15px 0;
}
.table {
    border-collapse: collapse !important;
    width: 100% !important;
}
.table th,
.table td {
    padding: 12px !important;
    border: 1px solid #dee2e6 !important;
}
.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
<?php
        break;

    case 'input':
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Input Level</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Level</h3>
                </div>
                <form action="proses_level.php?proses=insert" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_level">Nama Level</label>
                            <input type="text" class="form-control" id="nama_level" name="nama_level" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-warning">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <a href="index.php?p=level" class="btn btn-danger">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
        break;

    case 'edit':
        $stmt = $pdo->prepare("SELECT * FROM level WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Edit Level</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Level</h3>
                </div>
                <form action="proses_level.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_level">Nama Level</label>
                            <input type="text" class="form-control" id="nama_level" name="nama_level" value="<?= htmlspecialchars($data['nama_level']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= htmlspecialchars($data['keterangan']) ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-secondary" name="reset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
        break;
}
?>