<?php
session_start(); // Memulai sesi
$error = $_SESSION['login_error'] ?? ''; // Mengambil pesan error jika ada
unset($_SESSION['login_error']); // Menghapus pesan error setelah ditampilkan
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | SimpleBlog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-8 col-md-5 col-lg-4">
        <div class="card">
          <h3>Masuk ke SimpleBlog</h3>
          <!-- Menampilkan pesan error jika ada -->
          <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?= $error ?></div>
          <?php endif; ?>
          <!-- Form login -->
          <form action="login_proses.php" method="POST" class="mt-4">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" class="form-control" name="password" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-kb">Masuk</button>
            </div>
          </form>
          <p class="text-center text-muted mt-4">
            Belum punya akun? <a href="register.php" class="text-decoration-none fw-semibold" style="color: rgb(255, 255, 255);">Daftar sekarang</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
