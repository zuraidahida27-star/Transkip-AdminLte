<?php
// Koneksi ke database
require_once __DIR__ . "/koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>My Guests List</title>
</head>
<body>

    <!-- Tombol Add My Guest -->
    <a href="form_guest.html" style="display: inline-block; padding: 6px 12px; background-color: #f8f9fa; border: 1px solid #ccc; color: black; text-decoration: none; border-radius: 4px; margin-bottom: 15px;">Add My Guest</a>

    <?php
    // Mengambil data dari tabel MyGuests
    $sql = "SELECT id, firstname, lastname, email, reg_date FROM MyGuests";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<h2 style="text-align: center; width: 650px;">My Guests List</h2>';
        echo '<table border="1" cellpadding="8" cellspacing="0">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Full Name</th>';
        echo '<th>Email</th>';
        echo '<th>Reg Date</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        
        while($row = mysqli_fetch_assoc($result)) {
            // Lewati baris jika firstname dan lastname kosong
            if (empty($row["firstname"]) && empty($row["lastname"])) {
                continue;
            }

            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["reg_date"] . "</td>";
            echo "<td>";
            echo "<a href='form_edit.php?id=" . $row["id"] . "'><button>Edit</button></a> | ";
            echo "<a href='hapus_guest.php?id=" . $row["id"] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">";
            echo "<button>Delete</button>";
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