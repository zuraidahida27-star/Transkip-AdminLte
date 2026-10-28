<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo "ID tidak valid!";
    exit;
}

// Ambil data berdasarkan ID yang dipilih
$sql = "SELECT * FROM MyGuests WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Edit Guest</title>
</head>
<body>

    <!-- Menampilkan data lama di bagian atas sesuai layar dosen -->
    <?php 
    echo $row["id"] . "<br>";
    echo $row["firstname"] . "<br>";
    echo $row["lastname"] . "<br>";
    echo $row["email"] . "<br><br>";
    ?>

    <h2>Form Edit My Guests</h2>
    <form action="updatedata.php" method="POST">
        <!-- Menyimpan ID secara tersembunyi -->
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="fname">First Name:</label><br>
        <input type="text" name="fname" value="<?php echo $row['firstname']; ?>" required><br>

        <label for="lname">Last Name:</label><br>
        <input type="text" name="lname" value="<?php echo $row['lastname']; ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

        <input type="reset" value="Cancel">
        <input type="submit" value="Update">
    </form>

</body>
</html>