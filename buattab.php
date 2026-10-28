<?php
require_once __DIR__ . "/koneksi.php";

// SQL untuk membuat tabel galeri
$sql = "CREATE TABLE galeri (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    namafile VARCHAR(100) NOT NULL,
    tgl_unggah TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Eksekusi kueri ke database
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'galeri' berhasil dibuat.";
} else {
    echo "Gagal membuat tabel: " . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);
?>