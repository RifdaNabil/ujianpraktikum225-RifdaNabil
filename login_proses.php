<?php
session_start(); // Memulai sesi
require "../config/connection.php"; //koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === "POST") {   //Cek apakah metode request adalah POST
    $email = htmlspecialchars($_POST['email']); //Ambil data email dari form login yang dikirim via POST.
    $password = htmlspecialchars($_POST['password']); //Ambil data password dari form login yang dikirim via POST.

    // Validasi input kosong
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email dan password wajib diisi.";
        header("Location: ../login.php");
        exit();
    }

    // Cek pengguna berdasarkan email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $connect->prepare($query); //menyiapkan query
    $stmt->bind_param("s", $email); //mengikat paramater
    $stmt->execute(); //menjalankan query
    $result = $stmt->get_result(); //mengambil hasil query
    $user = $result->fetch_assoc(); //mengambil data user sebagai array asosiatif

    // Cek password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        header("Location: dashboard.php"); // Lokasi dashboard kamu
        exit();
    } else {
        $_SESSION['login_error'] = "Email atau password salah.";
        header("Location: login.php");
        exit();
    }
}
