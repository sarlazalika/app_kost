<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID tidak valid!');
}

// Ambil data lama
$result = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE id = $id");
$data = mysqli_fetch_assoc($result);
if (!$data) {
    die('Data tidak ditemukan!');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'] ? $_POST['tgl_keluar'] : NULL;

    $query = "UPDATE tb_penghuni SET nama=?, no_ktp=?, no_hp=?, tgl_masuk=?, tgl_keluar=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $nama, $no_ktp, $no_hp, $tgl_masuk, $tgl_keluar, $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Gagal update data: ' . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Penghuni Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Edit Penghuni Kost</h2>
    <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
    <form method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No KTP</label>
            <input type="text" name="no_ktp" class="form-control" value="<?= htmlspecialchars($data['no_ktp']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" class="form-control" value="<?= htmlspecialchars($data['tgl_masuk']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Keluar</label>
            <input type="date" name="tgl_keluar" class="form-control" value="<?= htmlspecialchars($data['tgl_keluar']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
</body>
</html> 