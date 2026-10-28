<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";

// Menangkap data dari form_guest.html
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';

// Query untuk memasukkan data ke tabel MyGuests
$sql = "INSERT INTO MyGuests (firstname, lastname, email, reg_date)
        VALUES ('$firstname', '$lastname', '$email', NOW())";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('New record created successfully'); window.location='bacadata2.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>