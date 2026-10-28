<?php
// inisialisasi status upload
$uploadOk = 1;

// definisikan direktori target/ tujuan
$target_dir = "galeri/";

// Pastikan folder 'galeri' ada, jika belum buat otomatis
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$file_path = $target_dir . basename($_FILES["foto"]["name"]);

// mengubah ekstensi file menjadi huruf kecil
$imageFileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    // Tangkap data dari form
    $namaFile = $_FILES["foto"]["name"];
    $tipeFile = $_FILES["foto"]["type"];
    $ukuranFile = $_FILES["foto"]["size"];
    $fileSementara = $_FILES["foto"]["tmp_name"];
    $statusError = $_FILES["foto"]["error"];

    // Tampilkan informasi file
    echo "Nama File: " . htmlspecialchars($namaFile) . "<br>";
    echo "Tipe File: " . htmlspecialchars($tipeFile) . "<br>";
    echo "Ukuran File: " . $ukuranFile . " bytes<br>";
    echo "File Sementara: " . $fileSementara . "<br>";
    echo "Status Error: " . $statusError . "<br><br>";

    // Checkpoint 1 (Autentikasi apakah file adalah gambar)
    $cek = getimagesize($fileSementara);
    if ($cek !== false) {
        echo "File adalah sebuah gambar - " . $cek["mime"] . ".<br>";
    } else {
        echo "File bukan sebuah gambar.<br>";
        $uploadOk = 0;
    }

    // Checkpoint 2 (Duplikasi)
    if (file_exists($file_path)) {
        echo "Maaf, file " . basename($namaFile) . " sudah ada.<br>";
        $uploadOk = 0;
    }

    // Checkpoint 3 (Batasi Ukuran File - Maksimal 1 MB)
    if ($ukuranFile > 1000000) {
        echo "Maaf, ukuran file melebihi 1 MB<br>";
        $uploadOk = 0;
    }

    // Checkpoint 4 (Format file)
    if (
        $imageFileType != "jpg" && $imageFileType != "png" &&
        $imageFileType != "jpeg" && $imageFileType != "gif"
    ) {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.<br>";
        $uploadOk = 0;
    }

    // Jika status uploadOk = 1 pindahkan file ke direktori tujuan
    if ($uploadOk == 1) {
        // pindahkan fisik file ke direktori tujuan/ target
        if (move_uploaded_file($fileSementara, $file_path)) {
            echo "File " . basename($_FILES["foto"]["name"]) . " berhasil diunggah.<br>";
            
            // Tampilkan preview gambar
            echo "<br><img src='" . $file_path . "' alt='Preview Gambar' style='max-width: 400px; height: auto; border: 1px solid #ccc; padding: 5px;'><br>";
            
            // PERBAIKAN DI SINI: gunakan __DIR__ . "/koneksi.php"
            require_once __DIR__ . "/koneksi.php";
            
            // jalankan kueri
            $sql = "INSERT INTO galeri (namafile) VALUES ('$file_path')";
            
            // cek apakah kueri berhasil atau tidak
            if (mysqli_query($conn, $sql)) {
                echo "Data baru berhasil ditambahkan.<br>";
            } else {
                echo "Kesalahan dalam menambahkan data: " . mysqli_error($conn) . "<br>";
            }
            
            // tutup koneksi ke db
            mysqli_close($conn);
        }
    } else {
        echo "<br>Maaf, file tidak dapat diunggah.<br>";
    }

    echo "<br><a href='form_upload.php'>&laquo; Kembali ke Form Upload</a>";
}
?>