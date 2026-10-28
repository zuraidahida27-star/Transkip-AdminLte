<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tambah Data Nilai</title>
</head>
<body>

    <h2>Form Tambah Data Nilai Mahasiswa</h2>
    <form action="tambahnilai.php" method="POST">
        <label for="nim">NIM:</label><br>
        <input type="text" name="nim" required><br><br>

        <label for="nama_lengkap">Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" required><br><br>

        <label for="nilai_akhir">Nilai Akhir:</label><br>
        <input type="number" step="0.01" name="nilai_akhir" required><br><br>

        <label for="nilai_huruf">Nilai Huruf:</label><br>
        <input type="text" name="nilai_huruf" required><br><br>

        <label for="predikat">Predikat:</label><br>
        <input type="text" name="predikat" required><br><br>

        <input type="reset" value="Reset">
        <input type="submit" value="Simpan">
    </form>
    
    <br>
    <a href="bacanilaimhsw.php">&laquo; Kembali ke Rekap Nilai</a>

</body>
</html>