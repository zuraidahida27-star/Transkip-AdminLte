<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db5d"; // Sesuaikan nama database Anda di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal");
}

if (isset($_POST['nim']) && isset($_POST['nama_lengkap']) && isset($_POST['nilai_akhir'])) {
    $nim          = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nilai_akhir  = floatval($_POST['nilai_akhir']);

    if ($nilai_akhir >= 85) {
        $nilai_huruf = 'A';
        $predikat    = 'Sangat Memuaskan';
    } else if ($nilai_akhir >= 75) {
        $nilai_huruf = 'B';
        $predikat    = 'Memuaskan';
    } else if ($nilai_akhir >= 60) {
        $nilai_huruf = 'C';
        $predikat    = 'Cukup';
    } else {
        $nilai_huruf = 'D';
        $predikat    = 'Kurang';
    }

    $reg_date = date('Y-m-d H:i:s');

    $query = "INSERT INTO nilaimhsw (nim, nama_lengkap, nilai_akhir, nilai_huruf, predikat, reg_date) 
              VALUES ('$nim', '$nama_lengkap', '$nilai_akhir', '$nilai_huruf', '$predikat', '$reg_date')";
    
    if (mysqli_query($conn, $query)) {
        echo "sukses";
    } else {
        echo "gagal";
    }
}
?>