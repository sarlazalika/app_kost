<?php
// File: backend/db.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_kost';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?> 