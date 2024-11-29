<head>
    <!-- Link FontAwesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Matakuliah
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=matakuliah&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Matakuliah
                    </a>
                </div>
                <table id="tabelMatakuliah" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id</th>
                            <th>Kode Matakuliah</th>
                            <th>Nama Matakuliah</th>
                            <th>Semester</th>
                            <th>Jenis Matakuliah</th>
                            <th>Sks</th>
                            <th>Jam</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM matakuliah");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['id']) ?></td>
                            <td><?= htmlspecialchars($data['kode_matakuliah']) ?></td>
                            <td><?= htmlspecialchars($data['nama_matakuliah']) ?></td>
                            <td><?= htmlspecialchars($data['semester']) ?></td>
                            <td><?= htmlspecialchars($data['jenis_matakuliah']) ?></td>
                            <td><?= htmlspecialchars($data['sks']) ?></td>
                            <td><?= htmlspecialchars($data['jam']) ?></td>
                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            <td>
                                <a href="index.php?p=matakuliah&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="proses_matakuliah.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
    break;

    case 'input':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=matakuliah">Matakuliah</a></li>
            <li class="breadcrumb-item active">Tambah Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Form Tambah Matakuliah 
            </div>

            <div class="card-body">
                <form action="proses_matakuliah.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Matakuliah</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_matakuliah" value="Teori" required>
                                <label class="form-check-label">Teori</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_matakuliah" value="Praktek" required>
                                <label class="form-check-label">Praktek</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sks</label>
                        <input type="number" class="form-control" name="sks" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan" required></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Submit</button>
                        <button type="reset" class="btn btn-secondary" name="reset"><i class="fas fa-undo"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    break;

    case 'edit':
        try {
            $stmt = $pdo->prepare("SELECT * FROM matakuliah WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data_matakuliah = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=matakuliah">Matakuliah</a></li>
            <li class="breadcrumb-item active">Edit Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Form Edit Matakuliah
            </div>
            <div class="card-body">
                <form action="proses_matakuliah.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= $data_matakuliah['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah" value="<?= $data_matakuliah['kode_matakuliah'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah" value="<?= $data_matakuliah['nama_matakuliah'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" value="<?= $data_matakuliah['semester'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Matakuliah</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_matakuliah" value="Teori" <?= $data_matakuliah['jenis_matakuliah'] == 'Teori' ? 'checked' : '' ?> required>
                                <label class="form-check-label">Teori</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_matakuliah" value="Praktek" <?= $data_matakuliah['jenis_matakuliah'] == 'Praktek' ? 'checked' : '' ?> required>
                                <label class="form-check-label">Praktek</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sks</label>
                        <input type="number" class="form-control" name="sks" value="<?= $data_matakuliah['sks'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" value="<?= $data_matakuliah['jam'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan" required><?= $data_matakuliah['keterangan'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Submit</button>
                        <button type="reset" class="btn btn-secondary" name="reset"><i class="fas fa-undo"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    break;
}
?>
