<?php
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_kamar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kamar Kost</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #888; padding: 8px 12px; text-align: center; }
        th { background: #eee; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Data Kamar Kost</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Harga Sewa</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nomor']) ?></td>
            <td><?= number_format($row['harga'],0,',','.') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div style="text-align:center">
        <a href="tambah.php">Tambah Kamar</a>
    </div>
</body>
</html> 