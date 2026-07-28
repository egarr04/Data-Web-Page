<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        header, footer {
            width: 100%;
            background-color: #ffb6c1;
            padding: 1px;
            
        }
  
        .Kaler {
            color: #ffffff;
        }
        .content{
            display: flex;
            flex: 1;
            flex-wrap: wrap;
            
        }
        
        .setail:hover{
            background-color: #04aaa5;
            text-shadow: 3px 3px 3px #000000;
        }

        .setail {
        padding: 5px 5px;
        font-size: 12px;
        text-align: center;
        cursor: pointer;
        outline: none;
        color: #fff;
        background-color: #41dae4;
        border: none;
        border-radius: 1px;
        box-shadow: 0 9px #999;
        }
        
        .setail:active {
        background-color: #04aaa5;
        box-shadow: 0 5px #666;
        transform: translateY(4px);

        }
        nav  {
            padding: 20px;
            background-color: #ffffff;
            border: 2px solid #ccc;
            margin: 10px;
            border-radius: 20px;
        }

        aside {
            padding: 20px;
            background-color: #ffffff;
            border: 2px solid #ccc;
            margin: 10px;
            border-radius: 20px;
            text-align: center;
        }

        article {
            padding: 20px;
            border: 1px solid #ccc;
            margin: 10px;
            flex: 2; 
        }

        a {
        text-decoration: none;
        display: inline-block;
        padding: 8px 16px;
        }

        a:hover {
        background-color: #ddd;
        color: black;
        }

        .Berikut {
        background-color: #00d9ff;
        color: white;
        }

        .round {
        border-radius: 50%;
        }
        table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}


        @media (max-width: 767px) {
            /* Smartphone Layout */
            nav, article, aside {
                width: 100%;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            /* Tablet Layout */
            nav {
                width: 25%;
            }
            article {
                width: 75%;
            }
            aside {
                width: 100%;
            }
        }

        @media (min-width: 992px) {
            /* Desktop Layout */
            nav {
                width: 25%;
            }
            article {
                width: 50%;
            }
            aside {
                width: 25%;
            }
        }
    </style>
    <title>Responsive Web</title>
</head>
<body>
    <div class="wrapper">
        <header>
          <?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'pibs_web';


$con = new mysqli($host, $user, $pass, $db);


if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}


$query = "SELECT * FROM tbl_perusahaan";
$result = $con->query($query);


echo "<div style='width:100%; margin: 0 auto;'>";
if ($row = $result->fetch_assoc()) {
    echo "<div style='display: flex; align-items: center;'>";
    echo "<img src='data:image/jpeg;base64," . base64_encode($row['logo_Perusahaan']) . "' alt='Gambar Artikel' style='object-fit: contain; width: 100px; height: 100px; margin-right:10px;'>";
    echo "<div>";
    echo "<h2>" . $row['nm_Perusahaan'] . "</h2>";  
    echo "<p>" . $row['clb_Prodi'] . "</p>";
    echo "<p>" . $row['alamat'] . "</p>";
    echo "</div>";
    echo "</div>";
}



$con->close();
?>
        </header>
        <div class="content">
            <nav>
            <?php
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'pibs_web';

            $conn = mysqli_connect($host, $username, $password, $database);

            if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
            }

            $query = "SELECT * FROM tbl_nav";
            $result = mysqli_query($conn, $query);

            // Menampilkan data nav
            echo "<div style='width: 100%; margin: 0 auto;'>";
            while ($row = $result->fetch_assoc()) {
            echo "<div style='display: flex; padding: 10px; border: 1px solid #ddd;'>";
            echo "<h2><a href='index.php?id=" . $row['konektor'] . "'>  " . $row['Txt_menu'] . "</a></h2>";
            echo "</div>";
            }
            echo "</div>";

            $conn->close();
            ?>
            </nav>
            <article>
            <?php
            //koneksi
            $host = 'localhost'; 
            $username = 'root'; 
            $password = ''; 
            $database = 'pibs_web';

            $conn = mysqli_connect($host, $username, $password, $database);

            if (!$conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM artikeldata ";
            $result = mysqli_query($conn, $query);
        ?>

        <table>
        <tr>
                <th>No</th>
                <th>Jumlah lulus </th>
                <th>Jumlah tidak lulus</th>
                <th>Jumlah uji emisi</th>
                <th>Bahan Bakar </th>
                <th>Gambar Bukti</th>
            </tr>
            <?php
                // Tampilkan tabel data artikel
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_Data'] . "</td>";
                        echo "<td>" . $row['Data_one'] . "</td>";
                        echo "<td>" . $row['Data_two'] . "</td>";
                        echo "<td>" . $row['Data_Three'] . "</td>";
                        echo "<td>" . $row['Tipe_bahan'] . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['Gambar_data']) . "' alt='Gambar Artikel' width='200' height='200'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data artikel</td></tr>";
                }



$conn->close();
?>
</table>
</article>

            <aside>
                <?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'pibs_web';


$con = new mysqli($host, $user, $pass, $db);


if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}


$query = "SELECT * FROM tbl_aside";
$result = $con->query($query);


while ($row = $result->fetch_assoc()) {
    echo "<div style='border: 1px solid #ccc; padding: 10px; display: flex; align-items: center;'>";
        echo "<div>";
        echo "<p>" . $row['Keterangan'] . "</p>";
        echo "</div>";
        echo "</div>";
}


$con->close();
?>
</aside>
        <footer>
        <?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'pibs_web';


$con = new mysqli($host, $user, $pass, $db);


if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}


$query = "SELECT * FROM tbl_perusahaan";
$result = $con->query($query);


echo "<div style='width:100%; margin: 0 auto;'>";
if ($row = $result->fetch_assoc()) {
    echo "<div style='display: flex; align-items: flex-start; justify-content: space-between;'>";
    echo "<div>";
    echo "<p style='color: black;'>X :" . $row['sosmed_Tweet'] . "</p>";
    echo "<p style='color: black;'>Facebook :" . $row['sosmed_Fb'] . "</p>";
    echo "<p style='color: black;'>Instagram :" . $row['sosmed_Ig'] . "</p>";
    echo "<p style='color: black; margin-left: 200px'>" . $row['kopirek'] . "</p>";
    echo "</div>";
    echo "<div>";
    echo "<h2>" . $row['nm_Perusahaan'] . "</h2>";  
    echo "<p>" . $row['clb_Prodi'] . "</p>";
    echo "</div>";
    echo "</div>";
}



$con->close();
?>
        </footer>
    </div>
</body> 
</html>
