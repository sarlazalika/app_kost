<?php
include '../db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'] ? $_POST['tgl_keluar'] : NULL;

    $query = "INSERT INTO tb_penghuni (nama, no_ktp, no_hp, tgl_masuk, tgl_keluar) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $nama, $no_ktp, $no_hp, $tgl_masuk, $tgl_keluar);
    if (mysqli_stmt_execute($stmt)) {
        $success = 'Data penghuni berhasil ditambahkan!';
        header('Location: index.php');
        exit;
    } else {
        $error = 'Gagal menambah data: ' . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penghuni Kost</title>
    <style>
        form { width: 350px; margin: 30px auto; padding: 20px; border: 1px solid #888; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input[type=text], input[type=date] { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 16px; }
        .msg { text-align: center; color: green; }
        .err { text-align: center; color: red; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Tambah Penghuni Kost</h2>
    <?php if ($success): ?><div class="msg"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="err"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>
        <label>No KTP</label>
        <input type="text" name="no_ktp" required>
        <label>No HP</label>
        <input type="text" name="no_hp" required>
        <label>Tanggal Masuk</label>
        <input type="date" name="tgl_masuk" required>
        <label>Tanggal Keluar</label>
        <input type="date" name="tgl_keluar">
        <button type="submit">Simpan</button>
        <a href="index.php" style="margin-left:10px">Kembali</a>
    </form>
</body>
</html> 