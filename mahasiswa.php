<h2>Data Mahasiswa</h2>
<table id="example" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>Prodi</th>
            <th>No Telp</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include 'admin/koneksi.php';

            // Prepare the SQL query to join mahasiswa and prodi tables
            $stmt = $pdo->prepare("SELECT * FROM prodi INNER JOIN mahasiswa ON prodi.id = mahasiswa.prodi_id");
            $stmt->execute();

            $no = 1;

            // Fetch and display data
            while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= $no++ ?> </td>
            <td><?= htmlspecialchars($data_mhs['nim']) ?> </td>
            <td><?= htmlspecialchars($data_mhs['nama_mhs']) ?> </td>
            <td><?= htmlspecialchars($data_mhs['email']) ?> </td>
            <td><?= htmlspecialchars($data_mhs['nama_prodi']) ?> </td>
            <td><?= htmlspecialchars($data_mhs['notelp']) ?> </td>
            <td><?= htmlspecialchars($data_mhs['alamat']) ?> </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
