<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if ($user === 'sasa' && $pass === '12345') {
        $_SESSION['admin'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin Casa De Sasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<svg class="blob-bg top" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#f8bbd0"/></svg>
<svg class="blob-bg bottom" viewBox="0 0 400 400"><ellipse cx="200" cy="200" rx="200" ry="120" fill="#b2dfdb"/></svg>
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="mx-auto" style="max-width:400px;">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4"><i class="bi bi-person-lock me-2"></i>Login Admin</h3>
                <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-1"></i>Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 