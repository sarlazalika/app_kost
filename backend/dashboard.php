<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';
// Ringkasan data
$jml_penghuni = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_penghuni WHERE tgl_keluar IS NULL"))[0];
$jml_kamar = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_kamar"))[0];
$jml_barang = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_barang"))[0];
// Kamar kosong = kamar yang tidak ada di tb_kmr_penghuni dengan tgl_keluar IS NULL
$q_kosong = mysqli_query($conn, "SELECT * FROM tb_kamar WHERE id NOT IN (SELECT id_kamar FROM tb_kmr_penghuni WHERE tgl_keluar IS NULL)");
$jml_kosong = mysqli_num_rows($q_kosong);
// Tagihan belum lunas (status cicil)
$q_tagihan = mysqli_query($conn, "SELECT tb_penghuni.nama, tb_kamar.nomor, tb_tagihan.bulan, tb_tagihan.jml_tagihan, tb_bayar.jml_bayar FROM tb_bayar JOIN tb_tagihan ON tb_bayar.id_tagihan=tb_tagihan.id JOIN tb_kmr_penghuni ON tb_tagihan.id_kmr_penghuni=tb_kmr_penghuni.id JOIN tb_penghuni ON tb_kmr_penghuni.id_penghuni=tb_penghuni.id JOIN tb_kamar ON tb_kmr_penghuni.id_kamar=tb_kamar.id WHERE tb_bayar.status='cicil'");
// Penghuni baru bulan ini
$bulan_ini = date('Y-m');
$q_baru = mysqli_query($conn, "SELECT nama, tgl_masuk FROM tb_penghuni WHERE DATE_FORMAT(tgl_masuk, '%Y-%m') = '$bulan_ini'");
// Kamar akan jatuh tempo (tgl masuk +/- 3 hari dari hari ini)
$today = date('Y-m-d');
$q_jatuh = mysqli_query($conn, "SELECT tb_kamar.nomor, tb_penghuni.nama, tb_kmr_penghuni.tgl_masuk FROM tb_kmr_penghuni JOIN tb_kamar ON tb_kmr_penghuni.id_kamar=tb_kamar.id JOIN tb_penghuni ON tb_kmr_penghuni.id_penghuni=tb_penghuni.id WHERE tb_kmr_penghuni.tgl_keluar IS NULL AND DAYOFMONTH(tb_kmr_penghuni.tgl_masuk) BETWEEN DAYOFMONTH(DATE_SUB('$today', INTERVAL 3 DAY)) AND DAYOFMONTH(DATE_ADD('$today', INTERVAL 3 DAY))");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Casa De Sasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<!-- SVG Blob Background -->
<svg class="blob-bg top" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#f8bbd0"/></svg>
<svg class="blob-bg bottom" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#b2dfdb"/></svg>
<nav class="navbar navbar-expand-lg mb-4 shadow" style="background: linear-gradient(90deg, #f8bbd0 60%, #b2dfdb 100%);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
      <i class="bi bi-house-heart-fill me-2" style="font-size:1.5rem;color:#7b1fa2;"></i>
      <span>Casa De Sasa</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="penghuni/index.php"><i class="bi bi-people-fill me-1"></i>Penghuni</a></li>
        <li class="nav-item"><a class="nav-link" href="kamar/index.php"><i class="bi bi-door-open-fill me-1"></i>Kamar</a></li>
        <li class="nav-item"><a class="nav-link" href="barang/index.php"><i class="bi bi-box-seam me-1"></i>Barang</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4 mb-5">
    <h2 class="mb-4 text-center"><i class="bi bi-speedometer2 me-2"></i>Dashboard Casa De Sasa</h2>
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm border-0 bg-light">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-people-fill" style="font-size:2rem;color:#7b1fa2;"></i></div>
                    <h4 class="card-title mb-0"><?= $jml_penghuni ?></h4>
                    <div class="card-text">Penghuni Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm border-0 bg-light">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-door-open-fill" style="font-size:2rem;color:#7b1fa2;"></i></div>
                    <h4 class="card-title mb-0"><?= $jml_kamar ?></h4>
                    <div class="card-text">Total Kamar</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm border-0 bg-light">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-box-seam" style="font-size:2rem;color:#7b1fa2;"></i></div>
                    <h4 class="card-title mb-0"><?= $jml_barang ?></h4>
                    <div class="card-text">Jenis Barang</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm border-0 bg-light">
                <div class="card-body">
                    <div class="mb-2"><i class="bi bi-door-closed-fill" style="font-size:2rem;color:#ad1457;"></i></div>
                    <h4 class="card-title mb-0"><?= $jml_kosong ?></h4>
                    <div class="card-text">Kamar Kosong</div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-3 justify-content-center mb-5">
        <a href="penghuni/tambah.php" class="btn btn-primary"><i class="bi bi-person-plus-fill me-1"></i>Tambah Penghuni</a>
        <a href="kamar/tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah Kamar</a>
        <a href="barang/tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah Barang</a>
    </div>
    <hr class="mb-5">
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-person-heart me-2"></i>Penghuni Baru Bulan Ini</h5>
                    <ul class="list-group">
                        <?php if (mysqli_num_rows($q_baru) == 0): ?>
                            <li class="list-group-item text-muted">Belum ada penghuni baru bulan ini</li>
                        <?php else: while($b = mysqli_fetch_assoc($q_baru)): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($b['nama']) ?></span>
                                <span class="badge bg-success">Masuk: <?= htmlspecialchars($b['tgl_masuk']) ?></span>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-calendar2-week me-2"></i>Kamar Akan Jatuh Tempo</h5>
                    <ul class="list-group">
                        <?php if (mysqli_num_rows($q_jatuh) == 0): ?>
                            <li class="list-group-item text-muted">Tidak ada kamar yang akan jatuh tempo</li>
                        <?php else: while($j = mysqli_fetch_assoc($q_jatuh)): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-door-closed me-1"></i><?= htmlspecialchars($j['nomor']) ?> <span class="badge bg-info ms-2">Penghuni: <?= htmlspecialchars($j['nama']) ?></span></span>
                                <span class="badge bg-warning text-dark">Tgl Masuk: <?= htmlspecialchars($j['tgl_masuk']) ?></span>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="mb-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-door-closed-fill me-2"></i>Kamar Kosong</h5>
                    <ul class="list-group">
                        <?php if ($jml_kosong == 0): ?>
                            <li class="list-group-item text-muted">Semua kamar terisi</li>
                        <?php else: while($k = mysqli_fetch_assoc($q_kosong)): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-door-closed me-2"></i><?= htmlspecialchars($k['nomor']) ?></span>
                                <span class="badge bg-primary">Rp <?= number_format($k['harga'],0,',','.') ?></span>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-cash-coin me-2"></i>Tagihan Belum Lunas</h5>
                    <ul class="list-group">
                        <?php if (mysqli_num_rows($q_tagihan) == 0): ?>
                            <li class="list-group-item text-muted">Tidak ada tagihan cicil</li>
                        <?php else: while($t = mysqli_fetch_assoc($q_tagihan)): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($t['nama']) ?> <span class="badge bg-info ms-2">Kamar <?= htmlspecialchars($t['nomor']) ?></span></span>
                                <span>
                                    <span class="badge bg-warning text-dark">Tagihan: Rp <?= number_format($t['jml_tagihan'],0,',','.') ?></span>
                                    <span class="badge bg-danger">Bayar: Rp <?= number_format($t['jml_bayar'],0,',','.') ?></span>
                                </span>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 