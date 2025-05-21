<?php
session_start(); //memulai session
require '../config/connection.php'; //koneksi ke file database

$user_id = $_SESSION['user_id'];
// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil ID post dari URL
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    echo "ID postingan tidak ditemukan.";
    exit;
}

// Ambil data post yang akan diedit (pastikan milik user sendiri)
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    echo "Postingan tidak ditemukan atau bukan milik kamu.";
    exit;
}

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    if (!empty($title) && !empty($content)) {
        $update = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($connect, $update);
        mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $post_id, $user_id);
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Judul dan konten tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Postingan | SimpleBlog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2>Edit Postingan</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-secondary">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
