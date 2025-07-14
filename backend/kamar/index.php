<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_kamar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kamar Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<!-- SVG Blob Background -->
<svg class="blob-bg top" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#f8bbd0"/></svg>
<svg class="blob-bg bottom" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#b2dfdb"/></svg>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-door-open-fill me-2"></i>Data Kamar Kost</h2>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah Kamar</a>
    </div>
    <div class="row">
    <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-door-closed-fill me-2"></i><?= htmlspecialchars($row['nomor']) ?></h5>
                    <p class="card-text">Harga: <span class="badge bg-primary">Rp <?= number_format($row['harga'],0,',','.') ?></span></p>
                    <div class="d-flex gap-2">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i> Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 