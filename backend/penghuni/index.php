<?php
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_penghuni");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Penghuni Kost</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #888; padding: 8px 12px; text-align: center; }
        th { background: #eee; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Data Penghuni Kost</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No KTP</th>
            <th>No HP</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Keluar</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['no_ktp']) ?></td>
            <td><?= htmlspecialchars($row['no_hp']) ?></td>
            <td><?= htmlspecialchars($row['tgl_masuk']) ?></td>
            <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div style="text-align:center">
        <a href="tambah.php">Tambah Penghuni</a>
    </div>
</body>
</html> 