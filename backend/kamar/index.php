<?php
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_kamar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kamar Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Data Kamar Kost</h2>
    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Kamar</a>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nomor Kamar</th>
                <th>Harga Sewa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nomor']) ?></td>
                <td><?= number_format($row['harga'],0,',','.') ?></td>
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