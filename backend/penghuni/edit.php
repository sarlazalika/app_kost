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
$result = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE id = $id");
$data = mysqli_fetch_assoc($result);
if (!$data) {
    die('Data tidak ditemukan!');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $no_ktp = trim($_POST['no_ktp']);
    $no_hp = trim($_POST['no_hp']);
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'] ? $_POST['tgl_keluar'] : NULL;

    // Validasi server-side
    if ($nama === '' || $no_ktp === '' || $no_hp === '' || $tgl_masuk === '') {
        $error = 'Semua field wajib diisi (kecuali tanggal keluar).';
    } elseif (!preg_match('/^\d{16}$/', $no_ktp)) {
        $error = 'No KTP harus 16 digit angka.';
    } elseif (!preg_match('/^\d{10,}$/', $no_hp)) {
        $error = 'No HP minimal 10 digit angka.';
    } elseif ($tgl_keluar && $tgl_keluar < $tgl_masuk) {
        $error = 'Tanggal keluar tidak boleh sebelum tanggal masuk.';
    } else {
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
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Penghuni Kost</title>
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
        <li class="nav-item"><a class="nav-link active" href="../penghuni/index.php"><i class="bi bi-people-fill me-1"></i>Penghuni</a></li>
        <li class="nav-item"><a class="nav-link" href="../kamar/index.php"><i class="bi bi-door-open-fill me-1"></i>Kamar</a></li>
        <li class="nav-item"><a class="nav-link" href="../barang/index.php"><i class="bi bi-box-seam me-1"></i>Barang</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="mx-auto" style="max-width:430px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="card-title text-center mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Penghuni Kost</h3>
            <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
            <form method="post" onsubmit="return validateForm()">
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
                    <label class="form-label">Tanggal Keluar <span class="badge bg-secondary">Opsional</span></label>
                    <input type="date" name="tgl_keluar" class="form-control" value="<?= htmlspecialchars($data['tgl_keluar']) ?>">
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
    const nama = document.querySelector('[name=nama]').value.trim();
    const no_ktp = document.querySelector('[name=no_ktp]').value.trim();
    const no_hp = document.querySelector('[name=no_hp]').value.trim();
    const tgl_masuk = document.querySelector('[name=tgl_masuk]').value;
    const tgl_keluar = document.querySelector('[name=tgl_keluar]').value;
    if (!nama || !no_ktp || !no_hp || !tgl_masuk) {
        alert('Semua field wajib diisi (kecuali tanggal keluar).');
        return false;
    }
    if (!/^\d{16}$/.test(no_ktp)) {
        alert('No KTP harus 16 digit angka.');
        return false;
    }
    if (!/^\d{10,}$/.test(no_hp)) {
        alert('No HP minimal 10 digit angka.');
        return false;
    }
    if (tgl_keluar && tgl_keluar < tgl_masuk) {
        alert('Tanggal keluar tidak boleh sebelum tanggal masuk.');
        return false;
    }
    return true;
}
</script>
</body>
</html> 