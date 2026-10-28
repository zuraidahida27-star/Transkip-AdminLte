<?php
// Fungsi sanitasi input
function sanitasi($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Inisialisasi variabel awal
$step = 1;
$jumlah = 0;
$errJumlah = "";
$nama_arr = [];
$nilai_arr = [];

// Cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buat_form'])) {
        if (empty($_POST['jumlah']) || $_POST['jumlah'] < 1) {
            $errJumlah = "Jumlah mahasiswa harus diisi dengan benar!";
        } else {
            $jumlah = (int) $_POST['jumlah'];
            $step = 2;
        }
    } elseif (isset($_POST['simpan'])) {
        $step = 3;
        $jumlah = (int) $_POST['jumlah_hidden'];
        $nama_arr = $_POST['nama'] ?? [];
        $nilai_arr = $_POST['nilai'] ?? [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Nilai Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        fieldset {
            border: 1px solid #999;
            margin-bottom: 15px;
            padding: 10px 15px;
            width: 750px;
        }
        legend {
            font-weight: normal;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <h2>Form Input Nilai Mahasiswa</h2>

    <!-- TAHAP 1: Input Jumlah Mahasiswa -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="jumlah">Jumlah Mahasiswa:</label>
        <input type="number" name="jumlah" id="jumlah" value="<?php echo ($jumlah > 0) ? $jumlah : ''; ?>" min="1" required style="width: 80px;">
        <button type="submit" name="buat_form">Buat Form</button>
        <span class="error"><?php echo $errJumlah; ?></span>
    </form>

    <br>

    <!-- TAHAP 2 & 3: Form Input Dinamis & Tabel Hasil -->
    <?php if ($step >= 2 && $jumlah > 0): ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="jumlah_hidden" value="<?php echo $jumlah; ?>">
            <p><strong>Masukkan Data <?php echo $jumlah; ?> Mahasiswa</strong></p>

            <?php for ($i = 0; $i < $jumlah; $i++): ?>
                <fieldset>
                    <legend>Data ke-<?php echo ($i + 1); ?></legend>
                    
                    <label>Nama Mahasiswa:</label>
                    <input type="text" name="nama[]" value="<?php echo isset($nama_arr[$i]) ? htmlspecialchars($nama_arr[$i]) : ''; ?>" required style="width: 250px;">
                    
                    &nbsp;&nbsp;&nbsp;
                    
                    <label>Nilai Akhir:</label>
                    <input type="text" name="nilai[]" value="<?php echo isset($nilai_arr[$i]) ? htmlspecialchars($nilai_arr[$i]) : ''; ?>" required style="width: 100px;">
                </fieldset>
            <?php endfor; ?>

            <button type="submit" name="simpan">Simpan dan Tampilkan</button>
        </form>
    <?php endif; ?>

    <!-- TAHAP 3: Menampilkan Tabel Hasil di Bawah Form -->
    <?php if ($step == 3): ?>
        <h3>Data Nilai yang Diinput</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>Nama Mahasiswa</th>
                    <th style="width: 120px;">Nilai Akhir</th>
                    <th style="width: 100px;">Nilai Huruf</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < $jumlah; $i++) {
                    $nama_mhsw = sanitasi($nama_arr[$i] ?? '');
                    $nilai_raw = trim($nilai_arr[$i] ?? '');
                    
                    // Ubah koma menjadi titik untuk perhitungan
                    $nilai_num = str_replace(',', '.', $nilai_raw);
                    
                    $nilai_huruf = "";
                    $predikat = "";

                    if (!is_numeric($nilai_num)) {
                        $nilai_huruf = "Invalid";
                        $predikat = "Nilai harus berupa angka!";
                    } else {
                        $val = (float) $nilai_num;
                        
                        // Logika predikat dan nilai huruf sesuai standar
                        if ($val >= 85) {
                            $nilai_huruf = "A";
                            $predikat = "Sangat Memuaskan";
                        } elseif ($val >= 70) {
                            $nilai_huruf = "B";
                            $predikat = "Memuaskan";
                        } elseif ($val >= 55) {
                            $nilai_huruf = "C";
                            $predikat = "Cukup";
                        } elseif ($val >= 40) {
                            $nilai_huruf = "D";
                            $predikat = "Kurang";
                        } else {
                            $nilai_huruf = "E";
                            $predikat = "Gagal / Invalid Value!";
                        }
                    }

                    echo "<tr>";
                    echo "<td>" . ($i + 1) . "</td>";
                    echo "<td>" . $nama_mhsw . "</td>";
                    echo "<td>" . sanitasi($nilai_raw) . "</td>";
                    echo "<td>" . $nilai_huruf . "</td>";
                    echo "<td>" . $predikat . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">&larr; Input Data Baru Lagi</a>
    <?php endif; ?>

</body>
</html>