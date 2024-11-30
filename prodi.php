<h2>Data Prodi</h2>
<table id="example" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Prodi</th>
            <th>Jenjang</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include 'admin/koneksi.php';

            // Prepare the SQL query to fetch data from the prodi table
            $stmt = $pdo->prepare("SELECT * FROM prodi");
            $stmt->execute();

            $no = 1;

            // Fetch and display data
            while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data_prodi['nama_prodi']) ?></td>
            <td><?= htmlspecialchars($data_prodi['jenjang_prodi']) ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
