<?php
// Panggil koneksi database
require_once __DIR__ . "/koneksi.php";

// Ambil data dari tabel galeri
$sql = "SELECT id, namafile, tgl_unggah FROM galeri";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>My Photo Gallery</title>
</head>
<body>

    <!-- Tombol Tambah Foto di atas tabel -->
    <p>
        <a href="form_upload.php"><button type="button">Tambah Foto</button></a>
    </p>

    <?php
    // Process the result set
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1' style='border-collapse: collapse;' cellpadding='5'>";
        echo "<caption><strong>My Photo Gallery</strong></caption>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Nama File</th>";
        echo "<th>Tgl Unggah</th>";
        echo "<th>Pratinjau</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        
        $no = 1; // Untuk nomor urut tampilan
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td align='center'>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row["namafile"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["tgl_unggah"]) . "</td>";
            // Kolom Pratinjau
            echo "<td align='center'><img src='" . htmlspecialchars($row["namafile"]) . "' alt='Pratinjau' style='max-width: 100px; height: auto; display: block;'></td>";
            // Kolom Actions (Edit & Hapus)
            echo "<td align='center'>
                    <a href='edit.php?id=" . $row["id"] . "'>Edit</a> | 
                    <a href='hapus.php?id=" . $row["id"] . "' onclick='return confirm(\"Yakin ingin menghapus foto ini?\");'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Belum ada data di galeri.";
    }

    // Tutup koneksi
    mysqli_close($conn);
    ?>

</body>
</html>