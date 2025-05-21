<?php
session_start(); // WAJIB untuk menggunakan $_SESSION
require 'config/connection.php';

$fullname = $_SESSION['fullname'] ?? null;
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Post tidak ditemukan.";
    exit;
}

$stmt = $connect->prepare("SELECT posts.*, users.fullname FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$post = $result->fetch_assoc();

if (!$post) {
    echo "Post tidak ditemukan.";
    exit;
}

$fullname = $_SESSION['fullname'] ?? null;
// Ambil ID dari URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Post tidak ditemukan.";
    exit;
}

// Ambil data post dari database
$stmt = $connect->prepare("SELECT posts.*, users.fullname FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$post = $result->fetch_assoc();

if (!$post) {
    echo "Post tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($post['title']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="beranda.php">SimpleBlog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav ms-auto d-flex align-items-center gap-3 mb-0">
      <?php if ($fullname): ?>
        <li class="nav-item">
          <a class="nav-link px-2" href="users/dashboard.php">Halo, <?= htmlspecialchars($fullname) ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-2" href="users/logout.php">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link px-2" href="users/login.php">Login</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <h1 class= "text-center fw-bold"><?= htmlspecialchars($post['title']) ?></h1>
  <p class="text-muted">
    Ditulis oleh <strong><?= htmlspecialchars($post['fullname']) ?></strong> pada <?= date('d M Y H:i', strtotime($post['create_at'])) ?>
  </p>

  <div class="mt-4">
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
  </div>

  <a href="beranda.php" class="btn mt-4">← Kembali ke Beranda</a>

</div>
</body>
</html>
