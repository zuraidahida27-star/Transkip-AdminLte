<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";

// Menangkap parameter id dari URL
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM MyGuests WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, kembali ke halaman bacadata2.php
        echo "<script>alert('Record deleted successfully'); window.location='bacadata2.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak valid!";
}

mysqli_close($conn);
?>