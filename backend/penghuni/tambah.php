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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Tambah Penghuni Kost</h2>
    <?php if ($success): ?><div class="alert alert-success text-center"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
    <form method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No KTP</label>
            <input type="text" name="no_ktp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Keluar</label>
            <input type="date" name="tgl_keluar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
</body>
</html> 