<?php
// Panggil koneksi database
require_once __DIR__ . "/koneksi.php";

// Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil data namafile dari database terlebih dahulu untuk mengetahui lokasi gambarnya
    $sql_select = "SELECT namafile FROM galeri WHERE id = '$id'";
    $result = mysqli_query($conn, $sql_select);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $file_path = $data['namafile'];

        // 2. Hapus file fisik gambar di dalam folder 'galeri/' jika file tersebut ada
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // 3. Hapus data dari tabel 'galeri' di database (phpMyAdmin)
        $sql_delete = "DELETE FROM galeri WHERE id = '$id'";
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>
                    alert('Data dan file foto berhasil dihapus!');
                    window.location.href = 'bacagaleri.php';
                  </script>";
        } else {
            echo "Gagal menghapus data dari database: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = 'bacagaleri.php';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan ke halaman bacagaleri.php
    header("Location: bacagaleri.php");
    exit;
}

// Tutup koneksi
mysqli_close($conn);
?>