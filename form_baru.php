<?php
//fungsi sanitasi input
function sanitasi($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//inisialisasi variabel set bernilai kosong
$errNama = $errNilai = $nama_mhsw = $nilai_akhir = "";
$val_nama = $val_nilai = false;
$nilai_huruf = "";
$predikat = "";

//menerima data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // cek apakah field nama kosong atau berisi
    if (empty($_POST["nama_mhsw"])) {
        $errNama = "Nama Mahasiswa tidak boleh kosong!";
    } else {
        $nama_mhsw = sanitasi($_POST["nama_mhsw"]);
        $val_nama = true;
    }

    // cek apakah field nilai kosong atau berisi
    if (!isset($_POST["nilai_akhir"]) || trim($_POST["nilai_akhir"]) === "") {
        $errNilai = "Nilai Akhir tidak boleh kosong!";
    } else {
        $nilai_input_raw = trim($_POST["nilai_akhir"]);
        
        // Ubah koma menjadi titik agar PHP bisa membaca angka desimalnya
        $nilai_input = str_replace(',', '.', $nilai_input_raw);
        
        // Cek apakah input berupa angka
        if (!is_numeric($nilai_input)) {
            $errNilai = "Nilai harus berupa angka!";
        } elseif ($nilai_input < 0 || $nilai_input > 100) {
            $errNilai = "Nilai harus diantara 0 sampai 100";
        } else {
            $nilai_akhir = sanitasi($nilai_input_raw); // Menampilkan sesuai yang diketik user
            $nilai_float = (float) $nilai_input;       // Untuk perhitungan predikat
            $val_nilai = true;

            // Menentukan Nilai Huruf dan Predikat berdasarkan rentang nilai
            if ($nilai_float >= 85) {
                $nilai_huruf = "A";
                $predikat = "Cum Laude / Sangat Memuaskan";
            } elseif ($nilai_float >= 70) {
                $nilai_huruf = "B";
                $predikat = "Memuaskan";
            } elseif ($nilai_float >= 55) {
                $nilai_huruf = "C";
                $predikat = "Cukup";
            } elseif ($nilai_float >= 40) {
                $nilai_huruf = "D";
                $predikat = "Kurang";
            } else {
                $nilai_huruf = "E";
                $predikat = "Gagal / Invalid Value!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Nilai Baru</title>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nama">Nama Mahasiswa:</label><span class="error">*</span><br>
            <input type="text" name="nama_mhsw" value="<?php echo $nama_mhsw; ?>">
            <span class="error"><?php echo $errNama; ?></span><br>

            <label for="nilai_akhir">Nilai Akhir:</label><span class="error">*</span><br>
            <input type="text" name="nilai_akhir" value="<?php echo $nilai_akhir; ?>">
            <span class="error"><?php echo $errNilai; ?></span><br>

            <span class="error">* wajib diisi</span><br><br>
            <input type="submit" value="Kirim">
        </form>

        <?php
        // Tampilkan data dan hasil konversi nilai jika lolos validasi
        if ($val_nama === true && $val_nilai === true) {
            echo "<h2>Data Nilai Mahasiswa</h2>";
            echo "Nama Mahasiswa: " . $nama_mhsw . "<br>";
            echo "Nilai Akhir: " . $nilai_akhir . "<br>";
            echo "Nilai Huruf: " . $nilai_huruf . "<br>";
            echo "Predikat: " . $predikat . "<br>";
        }
        ?>  
    </body>
</html>