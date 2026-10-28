<?php
require "koneksi.php";

$nim = $_POST['nim'] ?? '';
$nama_lengkap = $_POST['NamaL'] ?? '';
$nilai_akhir = $_POST['NilaiA'] ?? '';
$nilai_huruf = $_POST['NilaiH'] ?? '';
$predikat = $_POST['Predikat'] ?? '';

// Menggunakan reg_date sesuai dengan struktur kolom di phpMyAdmin
$sql = "INSERT IGNORE INTO Nilaimhsw (nim, nama_lengkap, nilai_akhir, nilai_huruf, predikat, reg_date)
VALUES ('$nim', '$nama_lengkap', '$nilai_akhir', '$nilai_huruf', '$predikat', NOW())";

if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
        echo "New record inserted successfully<br>";
    } else {
        echo "Gagal: NIM <strong>$nim</strong> sudah terdaftar di database!<br>";
    }
} else {
    echo "Error inserting record: " . mysqli_error($conn) . "<br>";
}

// Menambahkan tombol kembali ke form input
echo '<br><a href="form_nilai_mhsw.html" style="display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 15px;">+ Tambah Data Baru</a>';

echo "<br><hr><br>";

// Proses Hapus Data ditaruh di sini (di bawah, sebelum data ditampilkan)
if (isset($_GET['hapus'])) {
    $nim_hapus = $_GET['hapus'];
    $sql_hapus = "DELETE FROM Nilaimhsw WHERE nim = '$nim_hapus'";
    if (mysqli_query($conn, $sql_hapus)) {
        echo "<script>window.location='mhsw_guest.php';</script>";
        exit;
    }
}

// Menampilkan data dalam bentuk tabel HTML lengkap dengan kolom Tanggal Entri
$sql_tampil = "SELECT * FROM Nilaimhsw";
$result = mysqli_query($conn, $sql_tampil);

if (mysqli_num_rows($result) > 0) {
    // Judul diatur posisinya agar berada di tengah (menyesuaikan lebar tabel)
    echo "<h2 style='width: 790px; text-align: center;'>DATA MAHASISWA</h2>";
    
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>nim</th><th>Name</th><th>Nilai Akhir</th><th>Nilai Huruf</th><th>Predikat</th><th>Tanggal Entri</th><th>Aksi</th></tr>";
    
    while($row = mysqli_fetch_assoc($result)) {
        // Lewati jika data kosong
        if(empty($row["nama_lengkap"])) continue;
        
        echo "<tr>";
        echo "<td>" . $row["nim"] . "</td>"; 
        echo "<td>" . $row["nama_lengkap"] . "</td>"; 
        echo "<td>" . $row["nilai_akhir"] . "</td>"; 
        echo "<td>" . $row["nilai_huruf"] . "</td>"; 
        echo "<td>" . $row["predikat"] . "</td>"; 
        echo "<td>" . $row["reg_date"] . "</td>"; 
        // Tombol Edit (Hijau) dan Hapus (Merah)
        echo "<td>
                <a href='form_nilai_mhsw.html' style='background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px;'>Edit</a> 
                <a href='?hapus=" . $row["nim"] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")' style='background-color: #dc3545; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px;'>Hapus</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>