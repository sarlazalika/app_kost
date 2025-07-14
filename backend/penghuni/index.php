<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
include '../db.php';

$result = mysqli_query($conn, "SELECT * FROM tb_penghuni");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Penghuni Kost</title>
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
        <li class="nav-item"><a class="nav-link active" href="../penghuni/index.php"><i class="bi bi-people-fill me-1"></i>Penghuni</a></li>
        <li class="nav-item"><a class="nav-link" href="../kamar/index.php"><i class="bi bi-door-open-fill me-1"></i>Kamar</a></li>
        <li class="nav-item"><a class="nav-link" href="../barang/index.php"><i class="bi bi-box-seam me-1"></i>Barang</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i>Data Penghuni Kost</h2>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-person-plus-fill me-1"></i>Tambah Penghuni</a>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No KTP</th>
                <th>No HP</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ktp']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td><span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill px-3"><?= htmlspecialchars($row['tgl_masuk']) ?></span></td>
                <td>
                  <?php if ($row['tgl_keluar']): ?>
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill px-3"><?= htmlspecialchars($row['tgl_keluar']) ?></span>
                  <?php else: ?>
                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-3">Aktif</span>
                  <?php endif; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i> Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 