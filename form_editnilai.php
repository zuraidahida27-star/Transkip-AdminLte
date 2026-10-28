<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";

$nim = $_GET['nim'] ?? '';

if (empty($nim)) {
    echo "NIM tidak valid!";
    exit;
}

// Ambil data berdasarkan NIM yang dipilih
$sql = "SELECT * FROM nilaimhsw WHERE nim = '$nim'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data mahasiswa tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Edit Nilai Mahasiswa</title>
</head>
<body>

    <!-- Menampilkan data lama di bagian atas sesuai contoh -->
    <?php 
    echo $row["nim"] . "<br>";
    echo $row["nama_lengkap"] . "<br>";
    echo $row["nilai_akhir"] . "<br>";
    echo $row["nilai_huruf"] . "<br>";
    echo $row["predikat"] . "<br><br>";
    ?>

    <h2>Form Edit Nilai Mahasiswa</h2>
    <form action="updatenilai.php" method="POST">
        <!-- Menyimpan NIM secara tersembunyi sebagai primary key -->
        <input type="hidden" name="nim" value="<?php echo $row['nim']; ?>">

        <label for="nama_lengkap">Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" value="<?php echo $row['nama_lengkap']; ?>" required><br>

        <label for="nilai_akhir">Nilai Akhir:</label><br>
        <input type="number" step="0.01" name="nilai_akhir" value="<?php echo $row['nilai_akhir']; ?>" required><br>

        <label for="nilai_huruf">Nilai Huruf:</label><br>
        <input type="text" name="nilai_huruf" value="<?php echo $row['nilai_huruf']; ?>" required><br>

        <label for="predikat">Predikat:</label><br>
        <input type="text" name="predikat" value="<?php echo $row['predikat']; ?>" required><br><br>

        <input type="reset" value="Cancel">
        <input type="submit" value="Update">
    </form>

</body>
</html>