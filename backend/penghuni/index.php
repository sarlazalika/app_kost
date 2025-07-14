<?php
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_penghuni");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Penghuni Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Data Penghuni Kost</h2>
    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Penghuni</a>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No KTP</th>
                <th>No HP</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ktp']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td><?= htmlspecialchars($row['tgl_masuk']) ?></td>
                <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html> 