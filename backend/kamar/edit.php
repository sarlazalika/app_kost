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
    <style>
        form { width: 300px; margin: 30px auto; padding: 20px; border: 1px solid #888; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input[type=text], input[type=number] { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 16px; }
        .err { text-align: center; color: red; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Edit Kamar Kost</h2>
    <?php if ($error): ?><div class="err"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Nomor Kamar</label>
        <input type="text" name="nomor" value="<?= htmlspecialchars($data['nomor']) ?>" required>
        <label>Harga Sewa</label>
        <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required>
        <button type="submit">Update</button>
        <a href="index.php" style="margin-left:10px">Kembali</a>
    </form>
</body>
</html> 