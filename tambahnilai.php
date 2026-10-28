<?php
require_once __DIR__ . "/koneksi.php";

$nim = $_POST['nim'];
$nama_lengkap = $_POST['nama_lengkap'];
$nilai_akhir = $_POST['nilai_akhir'];

// Logika otomatis menentukan Nilai Huruf dan Predikat berdasarkan Nilai Akhir
if ($nilai_akhir >= 85) {
    $nilai_huruf = "A";
    $predikat = "Sangat Memuaskan";
} elseif ($nilai_akhir >= 75) {
    $nilai_huruf = "B";
    $predikat = "Memuaskan";
} elseif ($nilai_akhir >= 65) {
    $nilai_huruf = "C";
    $predikat = "Cukup";
} elseif ($nilai_akhir >= 50) {
    $nilai_huruf = "D";
    $predikat = "Kurang";
} else {
    $nilai_huruf = "E";
    $predikat = "Kurang Sekali";
}

// Simpan data ke database beserta nilai huruf dan predikat yang otomatis
$sql = "INSERT INTO nilaimhsw (nim, nama_lengkap, nilai_akhir, nilai_huruf, predikat) VALUES ('$nim', '$nama_lengkap', '$nilai_akhir', '$nilai_huruf', '$predikat')";

if (mysqli_query($conn, $sql)) {
    // Diarahkan kembali langsung ke tabel AdminLTE 4
    header('Location: admin-lte/tables/data.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>