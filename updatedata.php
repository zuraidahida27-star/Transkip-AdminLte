<?php
require_once __DIR__ . "/koneksi.php";

$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];

$sql = "UPDATE MyGuests SET firstname='$fname', lastname='$lname', email='$email' WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    // Jika berhasil, langsung alihkan kembali ke halaman tabel data
    header('Location: bacadata2.php');
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>