<?php
session_start(); // Memulai sesi
require '../config/connection.php'; // Tambahkan koneksi

// Cek apakah user sudah login
if (!isset($_SESSION['fullname']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
//Menyimpan fullname dan user_id dari session ke dalam variabel supaya lebih mudah dipakai di bawah.
$fullname = $_SESSION['fullname']; 
$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Pengguna | SimpleBlog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="../beranda.php">
      <span class="fw-bold fs-4">SimpleBlog</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav d-flex align-items-center gap-3 mb-0 ms-auto">
      <?php if ($fullname): ?>
        <li class="nav-item d-flex align-items-center">
          <a class="nav-link px-2" href="dashboard.php">Halo, <?= htmlspecialchars($fullname) ?></a>
        </li>
        <li class="nav-item d-flex align-items-center">
          <a class="nav-link px-2" href="logout.php">Logout</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>


    <!-- Toggler for mobile -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
  <span class="navbar-toggler-icon"></span>
</button>
</nav>

<div class="container py-5">
  <div class="text-center mb-4">
    <h2>Hai, <?= htmlspecialchars($fullname) ?> 👋</h2>
    <p>Selamat datang di dashboard WithBlog</p>
  </div>

  <!-- Tombol buat post -->
  <a href="create.php" class="btn btn-kb mb-3">+ Buat Postingan Baru</a>
  <?php
    // Ambil post milik user yang sedang login
    $query = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY create_at DESC";
    $result = mysqli_query($connect, $query);
  ?>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h4 class="card-title fw-semibold"><?= htmlspecialchars($row['title']) ?></h4>
          <p class="text-muted mb-2"><?= date('d M Y H:i', strtotime($row['create_at'])) ?></p>
          <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm me-2">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </div>
      </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Kamu belum membuat postingan apa pun.</p>
<?php endif; 

?>
