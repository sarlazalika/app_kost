<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
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
    $nomor = trim($_POST['nomor']);
    $harga = trim($_POST['harga']);

    // Validasi server-side
    if ($nomor === '' || $harga === '') {
        $error = 'Nomor kamar dan harga wajib diisi.';
    } elseif (!is_numeric($harga) || $harga <= 0) {
        $error = 'Harga harus berupa angka positif.';
    } else {
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
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kamar Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4 shadow" style="background: linear-gradient(90deg, #f8bbd0 60%, #b2dfdb 100%);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="../penghuni/index.php">
      <i class="bi bi-house-heart-fill me-2" style="font-size:1.5rem;color:#7b1fa2;"></i>
      <span>Aplikasi Kost</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../penghuni/index.php"><i class="bi bi-people-fill me-1"></i>Penghuni</a></li>
        <li class="nav-item"><a class="nav-link active" href="../kamar/index.php"><i class="bi bi-door-open-fill me-1"></i>Kamar</a></li>
        <li class="nav-item"><a class="nav-link" href="../barang/index.php"><i class="bi bi-box-seam me-1"></i>Barang</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="mx-auto" style="max-width:430px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="card-title text-center mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Kamar Kost</h3>
            <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
            <form method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label class="form-label">Nomor Kamar</label>
                    <input type="text" name="nomor" class="form-control" value="<?= htmlspecialchars($data['nomor']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Sewa <span class="badge bg-secondary">Rp</span></label>
                    <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="index.php" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateForm() {
    const nomor = document.querySelector('[name=nomor]').value.trim();
    const harga = document.querySelector('[name=harga]').value.trim();
    if (!nomor || !harga) {
        alert('Nomor kamar dan harga wajib diisi.');
        return false;
    }
    if (isNaN(harga) || Number(harga) <= 0) {
        alert('Harga harus berupa angka positif.');
        return false;
    }
    return true;
}
</script>
</body>
</html> 