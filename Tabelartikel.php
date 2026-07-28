<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="gayacrd.css">
    <title>List Data Artikel</title>
</head>
<body>
    <div class="container">
        <button onclick="window.location.href='Tambahartikel.php'" class="button button-add">ADD NEW</button>
        <br></br>
        <h2>Tabel Artikel</h2>

        <?php
            //koneksi
            $host = 'localhost'; 
            $username = 'root'; 
            $password = ''; 
            $database = 'pibs_web'; 

            $con = mysqli_connect($host, $username, $password, $database);

            if (!$con) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM artikel"; 
            $result = mysqli_query($con, $query);
        ?>

        <table>
            <tr>
                <th>ID Artikel</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            <?php
               
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_Judul'] . "</td>";
                        echo "<td>" . $row['Judul'] . "</td>";
                        echo "<td>" . $row['Deskripsi'] . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['Gambar']) . "' alt='Gambar Artikel' width='200' height='200'></td>";
                        echo "<td>";
                        echo "<button onclick=\"window.location.href='Editartikel.php?id=" . $row['id_Judul'] . "'\" class=\"button button-edit\">Edit Artikel</button><br></br><br>";
                        echo "<button onclick=\"window.location.href='Deleteartikel.php?id=" . $row['id_Judul'] . "'\" class=\"button button-delete\">Hapus</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data artikel</td></tr>";
                }

                
                mysqli_close($con);
            ?>
        </table>
    </div>
    <button onclick="window.location.href='index.php'" class="button button-add">Back</button>
</body>
</html>