<?php
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'pibs_web'; 

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $checkQuery = "SELECT * FROM artikel WHERE id_Judul = '$id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // untuk menampilkan pesan penghapusan
        echo "<script>
            var confirmed = confirm('Yakin Menghapus Artikel ?');
            if (confirmed) {
                // Menghapus data berdasarkan ID
                var deleteQuery = 'DELETE FROM artikel WHERE id_Judul = $id';
                var xhttp = new XMLHttpRequest();
                xhttp.open('POST', 'Deleteartikel.php?id=$id&confirmed=true', true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send('query=' + deleteQuery);
                window.location.href = 'Tabelartikel.php';
            } else {
                window.location.href = 'Tabelartikel.php';
            }
        </script>";
    } else {
        echo "<button onclick=\"window.location.href='Tabelartikel.php'\">OK</button>";
        exit;
    }
}

if (isset($_GET['confirmed']) && $_GET['confirmed'] === 'true') {
    $id = $_GET['id'];

    $deleteQuery = $_POST['query'];
    if (mysqli_query($con, $deleteQuery)) {
        $updateQuery = "SET @count = 0";
        mysqli_query($con, $updateQuery);
        $updateQuery = "UPDATE artikel SET artikel.id_Judul = @count:= @count + 1";
        mysqli_query($con, $updateQuery);
        $updateQuery = "ALTER TABLE artikel AUTO_INCREMENT = 1";
        mysqli_query($con, $updateQuery);

        echo "Data berhasil dihapus.";
        echo "<br><br>";
        echo "<button onclick=\"window.location.href='Tabelartikel.php'\">OK</button>";
        exit; 
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($con);
    }
}

mysqli_close($con);
?>
