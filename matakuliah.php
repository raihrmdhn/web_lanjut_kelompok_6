<h2>Data Mata Kuliah</h2>
<table id="example" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>Semester</th>
            <th>Jenis Mata Kuliah</th>
            <th>SKS</th>
            <th>Jam</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include 'admin/koneksi.php';

            // Prepare the SQL query to fetch data from the matakuliah table
            $stmt = $pdo->prepare("SELECT * FROM matakuliah");
            $stmt->execute();

            $no = 1;

            // Fetch and display data
            while ($data_matkul = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data_matkul['kode_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['nama_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['semester']) ?></td>
            <td><?= htmlspecialchars($data_matkul['jenis_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['sks']) ?></td>
            <td><?= htmlspecialchars($data_matkul['jam']) ?></td>
            <td><?= htmlspecialchars($data_matkul['keterangan']) ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
