<?php
session_start(); // Memulai sesi
$error = $_SESSION['error'] ?? []; //menampilkan pesan error
$old = $_SESSION['old'] ?? []; //membaca data input yang dikirim dari register_proses.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Akun - SimpleBlog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #FFF085;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .card {
      border: none;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      background-color: #FCB454;
    }

    h3 {
      font-weight: 700;
      color: #333;
      text-align: center;
    }

    .form-label {
      font-weight: 600;
      color: #555;
    }

    .btn-kb {
      background-color: #F16767;
      color: white;
      font-weight: 600;
      border: none;
    }

    .btn-kb:hover {
      background-color:rgb(202, 178, 178);
    }

    small.text-danger {
      font-size: 0.9rem;
    }

    .text-muted {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-lg p-4">
        <div class="card-body">
          <h3 class="text-center mb-4">Buat Akun Baru</h3>
          <!--Form input register-->
          <form action="register_proses.php" method="POST"> <!--Form ini akan mengirim data ke file register_proses.php menggunakan metode POST (data tidak terlihat di URL).-->

            <div class="mb-3">
              <label for="fullname" class="form-label">Nama Lengkap</label>
              <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
              <?php if(isset($error['fullname'])): ?>
                <small class="text-danger"><?= $error['fullname'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
              <?php if(isset($error['email'])): ?>
                <small class="text-danger"><?= $error['email'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" name="password" class="form-control">
              <?php if(isset($error['password'])): ?>
                <small class="text-danger"><?= $error['password'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="password_confirm" class="form-label">Konfirmasi Kata Sandi</label>
              <input type="password" name="password_confirm" class="form-control">
              <?php if(isset($error['password_confirm'])): ?>
                <small class="text-danger"><?= $error['password_confirm'] ?></small>
              <?php endif; ?>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-kb">Daftar</button>
            </div>
          </form>

          <div class="text-center mt-3">
            Sudah punya akun? <a href="login.php" class="text-decoration-none fw-semibold" style="color: rgb(255, 255, 255);">Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
