<?php
// Karena di folder utama web, cukup satu tingkat ke koneksi.php
require_once __DIR__ . "/koneksi.php";

$nim = $_GET['nim'] ?? '';

if (!empty($nim)) {
    $sql = "DELETE FROM nilaimhsw WHERE nim = '$nim'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location='admin-lte/tables/data.php';
              </script>";
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>