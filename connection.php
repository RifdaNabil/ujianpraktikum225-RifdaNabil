<?php
    $host="localhost"; //menyimpan alamat server database
    $user="root"; //menyimpan username database
    $pass=""; //menyimpan password database
    $db="blogdb"; //menyimpan nama database
    //koneksi ke database
    $connect= mysqli_connect($host, $user, $pass, $db); //menyimpan koneksi ke variabel $connect
    

    if (!$connect) { //jika koneksi gagal
        die("Error" . mysqli_connect_error()); //menampilkan pesan error
    }
?>