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
    <style>
        form { width: 350px; margin: 30px auto; padding: 20px; border: 1px solid #888; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input[type=text], input[type=date] { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 16px; }
        .err { text-align: center; color: red; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Edit Penghuni Kost</h2>
    <?php if ($error): ?><div class="err"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        <label>No KTP</label>
        <input type="text" name="no_ktp" value="<?= htmlspecialchars($data['no_ktp']) ?>" required>
        <label>No HP</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" required>
        <label>Tanggal Masuk</label>
        <input type="date" name="tgl_masuk" value="<?= htmlspecialchars($data['tgl_masuk']) ?>" required>
        <label>Tanggal Keluar</label>
        <input type="date" name="tgl_keluar" value="<?= htmlspecialchars($data['tgl_keluar']) ?>">
        <button type="submit">Update</button>
        <a href="index.php" style="margin-left:10px">Kembali</a>
    </form>
</body>
</html> 