<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID tidak valid!');
}

// Ambil data lama
$result = mysqli_query($conn, "SELECT * FROM tb_kamar WHERE id = $id");
$data = mysqli_fetch_assoc($result);
if (!$data) {
    die('Data tidak ditemukan!');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor = $_POST['nomor'];
    $harga = $_POST['harga'];

    $query = "UPDATE tb_kamar SET nomor=?, harga=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sii', $nomor, $harga, $id);
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
    <title>Edit Kamar Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Edit Kamar Kost</h2>
    <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
    <form method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label class="form-label">Nomor Kamar</label>
            <input type="text" name="nomor" class="form-control" value="<?= htmlspecialchars($data['nomor']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Sewa</label>
            <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
</body>
</html> 