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

// Update data ke database termasuk nilai huruf dan predikat yang otomatis
$sql = "UPDATE nilaimhsw SET nama_lengkap='$nama_lengkap', nilai_akhir='$nilai_akhir', nilai_huruf='$nilai_huruf', predikat='$predikat' WHERE nim='$nim'";

if (mysqli_query($conn, $sql)) {
    header('Location: admin-lte/tables/data.php');
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>