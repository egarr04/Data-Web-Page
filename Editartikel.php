<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Artikel</title>
    <link rel="stylesheet" type="text/css" href="gayacrd.css">
</head>
<body>
<div class="container">
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

    
    $query = "SELECT * FROM artikel WHERE id_Judul = '$id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['back'])) {
                
                header("Location: Tabelartikel.php");
                exit;
            } else {
                
                $judul = $_POST['Judul'];
                $deskripsi = $_POST['Deskripsi'];
                $gambar = addslashes(file_get_contents($_FILES['Gambar']['tmp_name'])); 

                
                $updateQuery = "UPDATE artikel SET Judul = '$judul', Deskripsi = '$deskripsi', Gambar = '$gambar' WHERE id_Judul = '$id'";
                if (mysqli_query($con, $updateQuery)) {
                    echo "Artikel berhasil diupdate";
                    echo "<br><br>";
                    echo "<button class='back-button' onclick=\"window.location.href='Tabelartikel.php'\">OK</button>";
                    exit; 
                } else {
                    echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
                }
            }
        } else {
            
            echo "<h2>Edit Artikel</h2>";
            echo "<form action='' method='POST' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='id' value='" . $row['id_Judul'] . "'>";
            echo "<label for='Judul'>Judul:</label><br>";
            echo "<input type='text' name='Judul' value='" . $row['Judul'] . "'><br><br>";

            echo "<label for='Deskripsi'>Deskripsi:</label><br>";
            echo "<textarea name='Deskripsi'>" . $row['Deskripsi'] . "</textarea><br><br>";

            echo "<label for='Gambar'>Gambar:</label><br>";
            echo "<div class='file-input'>";
            echo "<input type='file' name='Gambar' onchange='previewImage(event)'><br><br>";
            if ($row['Gambar']) {
                echo "<img id='preview-image' src='data:image/jpeg;base64," . base64_encode($row['Gambar']) . "' alt='Gambar Artikel' width='200' height='200'><br><br>";
            } else {
                echo "<img id='preview-image' src='' alt='Gambar Artikel' width='200' height='200'><br><br>";
            }
            echo "</div>";
            echo "<div class='button-container'>";
            echo "<button class='button tambah' type='submit'>Save</button>";
            echo "<button class='button back' name='back'>Kembali</button>";
            echo "</div>";
            echo "</form>";
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}

mysqli_close($con);
?>

<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var imgElement = document.getElementById("preview-image");
            imgElement.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
</div>
</body>
</html>
