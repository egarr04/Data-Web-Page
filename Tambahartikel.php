<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
    <link rel="stylesheet" type="text/css" href="gayacrd.css">
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Koneksi
            $host = 'localhost'; 
            $username = 'root'; 
            $password = ''; 
            $database = 'pibs_web'; 

            $con = mysqli_connect($host, $username, $password, $database);

            if (!$con) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }

            
            $judul = $_POST['Judul'];
            $deskripsi = $_POST['Deskripsi'];

            
            $gambar = $_FILES['Gambar']['tmp_name'];
            $gambarData = addslashes(file_get_contents($gambar));

            
            $query = "INSERT INTO artikel (Judul, Deskripsi, Gambar) VALUES ('$judul', '$deskripsi', '$gambarData')";
            $result = mysqli_query($con, $query);

            if ($result) {
                mysqli_close($con);
                echo "<div class='notification'>Artikel berhasil ditambahkan.</div>";
                echo "<br><br>";
                echo "<button onclick=\"window.location.href='Tabelartikel.php'\">OK</button>";
                exit; 
            } else {
                echo "Terjadi kesalahan: " . mysqli_error($con);
                mysqli_close($con);
            }
        }
        ?>
        
        
        <h2>Tambah Artikel Baru</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="Judul">Judul:</label>
            <input type="text" name="Judul" id="Judul" required>

            <label for="Deskripsi">Deskripsi:</label>
            <textarea name="Deskripsi" id="Deskripsi" rows="4" required></textarea>

            <label for="Gambar">Gambar:</label>
            <div class="file-input">
                <input type="file" name="Gambar" id="Gambar-file">
            </div>
            <div id="Gambar-preview"></div>

            <div class="button-container">
                <button type="submit" class="button tambah" name="tambah">Save</button>
                <button class="button back" onclick="window.location.href='Tabelartikel.php'">Kembali</button>
            </div>
        </form>

        <script>
            function showPreview(input) {
                var previewContainer = document.getElementById("Gambar-preview");
                previewContainer.innerHTML = "";

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var preview = document.createElement("img");
                        preview.setAttribute("src", e.target.result);
                        preview.setAttribute("width", "200");
                        preview.setAttribute("height", "200");

                        previewContainer.appendChild(preview);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            var fileInput = document.getElementById("Gambar-file");

            fileInput.addEventListener("change", function() {
                showPreview(this);
            });
        </script>
    </div>
</body>
</html>
