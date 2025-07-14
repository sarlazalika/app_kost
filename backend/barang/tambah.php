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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Tambah Barang Kost</h2>
    <?php if ($success): ?><div class="alert alert-success text-center"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
    <form method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
</body>
</html> 