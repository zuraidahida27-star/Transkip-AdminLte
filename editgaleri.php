<?php
require_once __DIR__ . "/koneksi.php";

// Pastikan ada parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: bacagaleri.php");
    exit;
}

$id = $_GET['id'];

// Ambil data gambar berdasarkan ID
$sql = "SELECT * FROM galeri WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan! <a href='bacagaleri.php'>Kembali</a>";
    exit;
}

// Proses jika form di-submit
if (isset($_POST['update'])) {
    $target_dir = "galeri/";
    
    // Cek apakah pengguna mengunggah foto baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $namaFile = $_FILES["foto"]["name"];
        $fileSementara = $_FILES["foto"]["tmp_name"];
        $ukuranFile = $_FILES["foto"]["size"];
        $file_path = $target_dir . basename($namaFile);
        $imageFileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Validasi tipe file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Hanya file JPG, JPEG, PNG & GIF yang diizinkan!');</script>";
        } elseif ($ukuranFile > 1000000) {
            echo "<script>alert('Ukuran file melebihi 1 MB!');</script>";
        } else {
            // Hapus file lama jika ada
            if (file_exists($data['namafile'])) {
                unlink($data['namafile']);
            }

            // Pindahkan file baru
            if (move_uploaded_file($fileSementara, $file_path)) {
                // Update ke database
                $update_sql = "UPDATE galeri SET namafile = '$file_path' WHERE id = '$id'";
                if (mysqli_query($conn, $update_sql)) {
                    echo "<script>alert('Foto berhasil diperbarui!'); window.location.href='bacagaleri.php';</script>";
                } else {
                    echo "Gagal memperbarui database: " . mysqli_error($conn);
                }
            } else {
                echo "Gagal mengunggah file baru.";
            }
        }
    } else {
        echo "<script>alert('Silakan pilih foto baru terlebih dahulu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Foto Galeri</title>
</head>
<body>

    <h2>Edit Foto Galeri</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <strong>Foto Saat Ini:</strong><br>
            <img src="<?php echo htmlspecialchars($data['namafile']); ?>" alt="Foto Lama" style="max-width: 150px; height: auto; border: 1px solid #ccc; padding: 5px; margin-top: 5px;">
        </p>

        <p>
            <label for="foto"><strong>Pilih Foto Baru:</strong></label><br>
            <input type="file" name="foto" id="foto" required>
        </p>

        <p>
            <button type="submit" name="update">Simpan Perubahan</button>
            <a href="bacagaleri.php"><button type="button">Batal</button></a>
        </p>
    </form>

</body>
</html>