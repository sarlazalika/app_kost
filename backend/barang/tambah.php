<?php
include '../db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO tb_barang (nama, harga) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $nama, $harga);
    if (mysqli_stmt_execute($stmt)) {
        $success = 'Data barang berhasil ditambahkan!';
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
    <title>Tambah Barang Kost</title>
    <style>
        form { width: 300px; margin: 30px auto; padding: 20px; border: 1px solid #888; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input[type=text], input[type=number] { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 16px; }
        .msg { text-align: center; color: green; }
        .err { text-align: center; color: red; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Tambah Barang Kost</h2>
    <?php if ($success): ?><div class="msg"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="err"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Nama Barang</label>
        <input type="text" name="nama" required>
        <label>Harga</label>
        <input type="number" name="harga" required>
        <button type="submit">Simpan</button>
        <a href="index.php" style="margin-left:10px">Kembali</a>
    </form>
</body>
</html> 