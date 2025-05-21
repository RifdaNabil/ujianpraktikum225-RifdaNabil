<?php
session_start(); // Memulai sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi
session_write_close(); // Tambahan opsional untuk memastikan sesi tertutup
header("Location: ../beranda.php"); // Redirect ke halaman beranda
exit();// Menghentikan eksekusi skrip setelah redirect
?>