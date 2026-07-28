<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cssintro.css">
    <title>Admin Utama</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        //tutup form tambah
        function toggleForm(formId) {
        var form = document.getElementById(formId);
        if (form) {
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    }

    //buka form tambah
    $(document).ready(function () {
        // Toggle Tambah Form
        $("#toggleTambahForm").click(function () {
            $("#tambahForm").toggle();
        });
    });

    //form edit
    $(document).ready(function() {
        // Handle cancel button click
        $("#btn_batal").click(function() {
            // Hide the form
            $("form").hide(); 
        });
    });

    </script>
</head>
<body>

<?php
// conn ke database
$conn = mysqli_connect("localhost", "root", "", "pibs_web") or die(mysqli_error());

// Fungsi tambah data
function tambah($conn)
{
    if (isset($_POST['btn_simpan'])) {
        $judul = $_POST['Judul'];
        $Deskripsi = $_POST['Deskripsi'];

        // Process image upload
        $gambar = addslashes(file_get_contents($_FILES['Gambar']['tmp_name']));

        if (!empty($judul) && !empty($Deskripsi)) {
            $sql = "INSERT INTO artikel (Gambar, Judul, Deskripsi) VALUES('" . $gambar . "','" . $judul . "','" . $Deskripsi . "')";
            $simpan = mysqli_query($conn, $sql);
            if ($simpan && isset($_GET['aksi'])) {
                if ($_GET['aksi'] == 'create') {
                    echo "Artikel berhasil ditambahkan.";
                }
            }
        } else {
            echo "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    // form tambah data
    ?>
	<div class="formTambah" id="tambahForm">
		<form action="" method="POST" enctype="multipart/form-data">
				<h2>Tambah Data</h2>
				<label>Judul <input type="text" name="Judul" /></label> <br>
				<label>Deskripsi <textarea name="Deskripsi"></textarea></label><br>
				<label>Gambar Artikel<input type="file" name="Gambar" accept="image/*" /></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_simpan" value="Simpan" />
					<input type="reset" name="reset" value="Bersihkan" />
				</label>
                <button type="button" onclick="toggleForm('tambahForm')" class="button button-add">Batal</button>
		</form>
	</div>

    <br><br>
	<button id="toggleTambahForm" class="button button-add">Tambah Artikel</button>


    <br><br
	<?php
}


// tabel data
function tampil_data($conn)
{
    $sql = "SELECT * FROM artikel";
    $query = mysqli_query($conn, $sql);

    echo "<fieldset>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>No</th>
            <th>Gambar Artikel</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tindakan</th>
          </tr>";

    while ($data = mysqli_fetch_array($query)) {
        ?>
		<tr>
			<td><?php echo $data['id_Judul']; ?></td>
			<td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode($data['Gambar']) . '" height="100" width="100"/>'; ?></td>
			<td><?php echo $data['Judul']; ?></td>
			<td><?php echo $data['Deskripsi']; ?></td>
			<td>
				<a href="crudintro.php?aksi=update&id_Judul=<?php echo $data['id_Judul']; ?>&judul=<?php echo $data['Judul']; ?>&Deskripsi=<?php echo $data['Deskripsi']; ?>">Edit</a> 
				<a href="crudintro.php?aksi=delete&id_Judul=<?php echo $data['id_Judul']; ?>">Hapus</a>
			</td>
		</tr>
		<?php
}
    echo "</table>";
    echo "</fieldset>";
}


// --- Fungsi edit data
function ubah($conn)
{
    // edit data
    if (isset($_POST['btn_ubah'])) {
        $id_Judul = $_POST['id_Judul'];
        $judul = $_POST['Judul'];
        $deskripsi = $_POST['Deskripsi'];

        if ($_FILES['Gambar']['size'] > 0) {
            $gambar = addslashes(file_get_contents($_FILES['Gambar']['tmp_name']));
            $updateImage = ", Gambar = '$gambar'";
        } else {
            $updateImage = "";
        }

        if (!empty($judul) && !empty($deskripsi)) {
            $perubahan = "Judul='" . $judul . "',Deskripsi='" . $deskripsi . "' $updateImage";
            $sql_update = "UPDATE artikel SET " . $perubahan . " WHERE id_Judul=$id_Judul";
            $update = mysqli_query($conn, $sql_update);
            if ($update) {
                header('location: crudintro.php');
                exit(); 
            } else {
                $pesan = "Gagal menyimpan perubahan!";
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }

    // tampilkan form edit
    if (isset($_GET['id_Judul'])) {
?>
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <h2>Ubah Artikel</h2>
                <input type="hidden" name="id_Judul" value="<?php echo $_GET['id_Judul'] ?>" />
                <label>Judul <input type="text" name="Judul" value="<?php echo $_GET['judul'] ?>" /></label> <br>
                <label>Deskripsi <textarea name="Deskripsi"><?php echo $_GET['Deskripsi'] ?></textarea></label><br>
                <label>Gambar Artikel <input type="file" name="Gambar" accept="image/*" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_ubah" value="Simpan Perubahan" />
                    atau <a href="crudintro.php?aksi=delete&id_Judul=<?php echo $_GET['id_Judul'] ?>"> (x) Hapus data ini</a>!
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>

                <button type="button" id="btn_batal">Batal</button>

            </fieldset>
        </form>


    

    
		<?php
}
}


// --- Fungsi Delete
function hapus($conn)
{
    if (isset($_GET['id_Judul']) && isset($_GET['aksi'])) {
        $id = $_GET['id_Judul'];
        $sql_hapus = "DELETE FROM artikel WHERE id_Judul=" . $id;
        $hapus = mysqli_query($conn, $sql_hapus);

        if ($hapus) {
            if ($_GET['aksi'] == 'delete') {
                header('location: crudintro.php');
            }
        }
    }

}


// --- Program Utama
if (isset($_GET['aksi'])) {
    switch ($_GET['aksi']) {
        case "create":
            echo '<a href="crudintro.php"> &laquo; Home</a>';
            tambah($conn);
            break;
        case "read":
            tampil_data($conn);
            break;
        case "update":
            ubah($conn);
            tampil_data($conn);
            break;
        case "delete":
            hapus($conn);
            break;
        default:
            echo "<h3>Aksi <i>" . $_GET['aksi'] . "</i> tidak ada!</h3>";
            tambah($conn);
            tampil_data($conn);
    }
} else {
    tambah($conn);
    tampil_data($conn);
}
?>
</body>
</html>