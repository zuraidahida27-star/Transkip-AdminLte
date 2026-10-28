<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Mahasiswa</title>
</head>
<body>

    <!-- Tombol untuk Tambah Data Nilai -->
    <a href="form_addnilai.php"><button>Tambah Data Nilai</button></a><br><br>

    <?php
    $sql = "SELECT * FROM nilaimhsw";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1" style="border-collapse: collapse;" cellpadding="5">';
        echo '<caption><strong>Rekap Nilai Mahasiswa</strong></caption>';
        echo '<tr>';
        echo '<th>NIM</th>';
        echo '<th>Nama Lengkap</th>';
        echo '<th>Nilai Akhir</th>';
        echo '<th>Nilai Huruf</th>';
        echo '<th>Predikat</th>';
        echo '<th>Tgl Dibuat</th>';
        echo '<th>Aksi</th>';
        echo '</tr>';

        while($row = mysqli_fetch_assoc($result)) {
            // Lewati baris jika NIM kosong
            if (empty($row["nim"])) {
                continue;
            }

            // Menggunakan reg_date sesuai kolom di database
            $tgl = $row["reg_date"] ?? $row["tgl_dibuat"] ?? '';

            echo "<tr>";
            echo "<td>" . ($row["nim"] ?? '') . "</td>";
            echo "<td>" . ($row["nama_lengkap"] ?? '') . "</td>";
            echo "<td>" . ($row["nilai_akhir"] ?? '') . "</td>";
            echo "<td>" . ($row["nilai_huruf"] ?? '') . "</td>";
            echo "<td>" . ($row["predikat"] ?? '') . "</td>";
            echo "<td>" . $tgl . "</td>";
            echo "<td>";
            echo "<a href='form_editnilai.php?nim=" . ($row["nim"] ?? '') . "'><button>Edit</button></a> | ";
            echo "<a href='hapusnilai.php?nim=" . ($row["nim"] ?? '') . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">";
            echo "<button>Hapus</button>";
            echo "</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results - Data not found!";
    }

    mysqli_close($conn);
    ?>

</body>
</html>