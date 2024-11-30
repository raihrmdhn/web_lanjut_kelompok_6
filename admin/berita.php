<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        ?>

        <div class="row-mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Berita</h1>
            </div>
            <div class="col-2 mb-3">
                <a href="index.php?p=berita&aksi=input" class="btn btn-primary"><i class="bi bi-building-add"></i> Tambah Berita</a>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    include 'koneksi.php';
                    $query = "SELECT berita.id, berita.judul, kategori.nama_kategori, user.email, berita.created_at 
                              FROM berita 
                              JOIN kategori ON berita.kategori_id = kategori.id 
                              JOIN user ON berita.user_id = user.id";
                    $stmt = $pdo->query($query);
                    $no = 1;
                    while ($data = $stmt->fetch()) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['judul'] ?></td>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['created_at'] ?></td>
                            <td>
                                <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="bi bi-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <?php
        break;

    case 'input':
        ?>

        <div class="row-mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Input Berita</h1>
            </div>
            <div class="col-6 mx-auto">
                <form action="proses_berita.php?proses=insert" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori_id">
                            <option selected>-Pilih Kategori-</option>
                            <?php
                            include 'koneksi.php';
                            $stmt = $pdo->query("SELECT * FROM kategori");
                            while ($data_kategori = $stmt->fetch()) {
                                echo "<option value='" . $data_kategori['id'] . "'>" . $data_kategori['nama_kategori'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control" name="fileToUpload" id="file-upload">
                    </div>
                    <div class="mb-4">
                        <img src="#" alt="Preview Uploaded Image" id="file-preview" width="300">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" rows="10" name="isi_berita"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        break;

    case 'edit':
        include 'koneksi.php';
        $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $data_berita = $stmt->fetch();
        ?>

        <div class="row-mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Berita</h1>
            </div>
            <div class="col-6 mx-auto">
                <form action="proses_berita.php?proses=edit" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="hidden" name="id" value="<?= $data_berita['id'] ?>">
                        <input type="text" class="form-control" name="judul" value="<?= $data_berita['judul'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori_id">
                            <option selected>-Pilih Kategori-</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM kategori");
                            while ($data_kategori = $stmt->fetch()) {
                                $selected = ($data_kategori['id'] == $data_berita['kategori_id'] ? 'selected' : '');
                                echo "<option value='" . $data_kategori['id'] . "' $selected>" . $data_kategori['nama_kategori'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control" name="fileToUpload" id="file-upload">
                    </div>
                    <div class="mb-4">
                        <img src="uploads/<?= $data_berita['file_upload'] ?>" alt="Preview Uploaded Image" id="file-preview" width="300">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" rows="10" name="isi_berita"><?= htmlspecialchars($data_berita['isi_berita']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        break;
}
?>

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
