<?php
session_start(); //memulai session
require '../config/connection.php'; //koneksi ke file database

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id']; 
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    echo "ID postingan tidak ditemukan.";
    exit;
}

// Pastikan postingan milik user
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($connect, $query); //menyiapkan query
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id); //mengikat parameter
mysqli_stmt_execute($stmt);//menjalankan query
$result = mysqli_stmt_get_result($stmt); //mengambl hasil query
$post = mysqli_fetch_assoc($result); //mengambil data post sebagai array asosiatif

if (!$post) {
    echo "Postingan tidak ditemukan atau bukan milik kamu.";
    exit;
}

// Hapus postingan
$delete = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($connect, $delete);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);

// Redirect ke dashboard
header("Location: dashboard.php");
exit;
?>
