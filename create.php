<?php
session_start(); // Mulai sesi
require '../config/connection.php';// Masukkan file koneksi ke database

// Cek apakah user sudah login
$user = $_SESSION['fullname'] ?? null; //Mengambil nama pengguna (fullname) dari session.
//Kalau belum login ($user kosong), langsung redirect ke login.php. Ini menjaga agar hanya user login yang bisa akses halaman ini.
if (!$user) {
    header("Location: login.php");
    exit;
}

// Ambil semua kategori dari database,Hasilnya disimpan dalam array $categories
$categories = [];
$catQuery = $connect->query("SELECT id, name FROM categories ORDER BY name ASC");
while ($cat = $catQuery->fetch_assoc()) {
    $categories[] = $cat;
}

// Proses jika form disubmit
//Cek apakah form sudah dikirim (method="POST"). Kalau iya, maka proses penyimpanan dijalankan.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? ''; // ambil title dari form
    $content = $_POST['content'] ?? ''; // ambil konten dari form
    $category_id = intval($_POST['category_id'] ?? 0); // ambil ID kategori dari form select,Gunakan intval() supaya category_id aman dan pasti berupa angka.

    //Validasi: Kalau salah satu kosong, muncul pesan error.
    if (empty($title) || empty($content) || $category_id <= 0) {
        $error = "Judul, Konten, dan Kategori harus diisi!";
    } else {
        
        $stmt = $connect->prepare("INSERT INTO posts (user_id, category_id, title, content, create_at) VALUES (?, ?, ?, ?, NOW())");// Masukkan data ke database
        $stmt->bind_param("iiss", $_SESSION['user_id'], $category_id, $title, $content);

        if ($stmt->execute()) {
            header("Location: ../beranda.php");
            exit;
        } else {
            $error = "Gagal menambahkan post, coba lagi!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!--mendukung karakter Unicode.-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--supaya tampilan responsif di HP.-->
    <title>Tambah Post - SimpleBlog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="../beranda.php">
      <span class="fw-bold fs-4 ">SimpleBlog</span>
    </a>
    <ul class="navbar-nav d-flex align-items-center gap-3 mb-0">
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
<!--
    - Form ini digunakan untuk menambah postingan baru.
    - Menggunakan metode POST untuk mengirim data ke create.php.
    - Memiliki dua input: satu untuk judul postingan dan satu untuk konten postingan.-->
<div class="container mt-5">
    <h2>Tambah Post Baru</h2>
    <form method="POST" action="create.php">
        <?php if (isset($error)): ?> <!-- Jika ada error, tampilkan pesan error -->
         <!-- Menggunakan htmlspecialchars untuk mencegah XSS -->
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="title" class="form-label">Judul Postingan</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Konten Postingan</label>
            <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
        </div>

        <!-- [UPDATED] Ganti input text kategori menjadi dropdown -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Pilih Kategori</label>
            <select id="category_id" name="category_id" class="form-select" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
    </select>
</div>


        <button type="submit" class="btn btn-secondary">Tambah Post</button> <!-- Tombol untuk mengirim form -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>