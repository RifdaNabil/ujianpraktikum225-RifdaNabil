<?php
session_start();
require './config/connection.php';
$fullname = $_SESSION['fullname'] ?? null;

$query = "SELECT posts.*, users.fullname, categories.name AS category_name
          FROM posts
          JOIN users ON posts.user_id = users.id
          JOIN categories ON posts.category_id = categories.id
          ORDER BY posts.create_at DESC";

$result = $connect->query($query);
$no_postingan = ($result->num_rows === 0);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container mt-4">
  <h3 class="mb-2 fw-bold underline">Welcome To the SimpleBlog</h3>
  <p class="mb-4 fst-italic">Share your Writings and Stories with the whole World.</p>

  <?php if ($no_postingan): ?>
    <div class="alert alert-warning">Belum ada postingan</div>
  <?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card h-100 shadow-sm rounded-4">
            <div class="card-body">
              <h6 class="card-title post-title">
                <a href="post.php?id=<?= $row['id'] ?>">
                  <?= htmlspecialchars($row['title']) ?>
                </a>
              </h6>
              <h6 class="card-subtitle mb-2">
                Ditulis oleh <?= htmlspecialchars($row['fullname']) ?> |
                <?= date('d M Y H:i', strtotime($row['create_at'])) ?>
              </h6>
              <span class="badge bg-secondary mb-2"><?= htmlspecialchars($row['category_name']) ?></span>
              <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
              <a href="post.php?id=<?= $row['id'] ?>" class="read-more">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
