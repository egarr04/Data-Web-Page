<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cssintro.css">
    <title>Admin Data</title>
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
        $Data = $_POST['Data_one'];
        $Data2 = $_POST['Data_two'];
        $Data3 = $_POST['Data_Three'];
        $Tipe_bahan = $_POST['Tipe_bahan'];

        // Process image upload
        $Gambar_data = addslashes(file_get_contents($_FILES['Gambar_data']['tmp_name']));

        if (!empty($Data) && !empty($Tipe_bahan)) {
            $sql = "INSERT INTO artikeldata (Gambar_data, Data_one, Data_two, Data_Three, Tipe_bahan) VALUES('" . $Gambar_data . "','" . $Data . "','" . $Data2 . "','" . $Data3 . "','" . $Tipe_bahan . "')";
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
				<label>Jumlah lulus <input type="text" name="Data_one" /></label> <br>
                <label>Jumlah tidak lulus <input type="text" name="Data_two" /></label> <br>
                <label>Jumlah Uji Emisi <input type="text" name="Data_Three" /></label> <br>
				<label>Bahan Bakar <textarea name="Tipe_bahan"></textarea></label><br>
				<label>Gambar_data Artikel<input type="file" name="Gambar_data" accept="image/*" /></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_simpan" value="Simpan" />
					<input type="reset" name="reset" value="Bersihkan" />
				</label>
                <button type="button" onclick="toggleForm('tambahForm')" class="button button-add">Batal</button>
		</form>
	</div>

    <br><br>
	<button id="toggleTambahForm" class="button button-add">Tambah Data</button>


    <br><br
	<?php
}


// tabel data
function tampil_data($conn)
{
    $sql = "SELECT * FROM artikeldata";
    $query = mysqli_query($conn, $sql);

    echo "<fieldset>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>No</th>
            <th>Bukti Data</th>
            <th>Jumlah lulus</th>
            <th>Jumlah tidak lulus</th>
            <th>Jumlah uji emisi</th>
            <th>Bahan Bakar</th>
            <th>Tindakan</th>
          </tr>";

    while ($data = mysqli_fetch_array($query)) {
        ?>
		<tr>
			<td><?php echo $data['id_Data']; ?></td>
			<td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode($data['Gambar_data']) . '" height="100" width="100"/>'; ?></td>
			<td><?php echo $data['Data_one']; ?></td>
            <td><?php echo $data['Data_two']; ?></td>
            <td><?php echo $data['Data_Three']; ?></td>
			<td><?php echo $data['Tipe_bahan']; ?></td>
			<td>
            <a href="cruddata.php?aksi=update&id_Data=<?php echo $data['id_Data']; ?>&Data_one=<?php echo $data['Data_one']; ?>&Data_two=<?php echo $data['Data_two']; ?>&Data_Three=<?php echo $data['Data_Three']; ?>&Tipe_bahan=<?php echo $data['Tipe_bahan']; ?>">Edit</a>
				<a href="cruddata.php?aksi=delete&id_Data=<?php echo $data['id_Data']; ?>">Hapus</a>
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
    // ubah data
    if (isset($_POST['btn_ubah'])) {
        $id_Data = $_POST['id_Data'];
        $Data_one = $_POST['Data_one'];
        $Data_two = $_POST['Data_two'];
        $Data_Three = $_POST['Data_Three'];
        $Tipe_bahan = $_POST['Tipe_bahan'];
    
        if ($_FILES['Gambar_data']['size'] > 0) {
            $Gambar_data = addslashes(file_get_contents($_FILES['Gambar_data']['tmp_name']));
            $updateImage = ", Gambar_data = '$Gambar_data'";
        } else {
            $updateImage = "";
        }
    
        if (!empty($Data_one) && !empty($Data_two) && !empty($Data_Three) && !empty($Tipe_bahan)) {
            $perubahan = "Data_one='" . $Data_one . "', Data_two='" . $Data_two . "', Data_Three='" . $Data_Three . "', Tipe_bahan='" . $Tipe_bahan . "' $updateImage";
            $sql_update = "UPDATE artikeldata SET " . $perubahan . " WHERE id_Data=$id_Data";
            $update = mysqli_query($conn, $sql_update);
            if ($update) {
                header('location: cruddata.php');
                exit(); // Tambahkan exit() untuk menghentikan eksekusi setelah mengarahkan header.
            } else {
                $pesan = "Gagal menyimpan perubahan!";
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    

    // tampilkan form edit
    if (isset($_GET['id_Data'])) {
?>
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <h2>Ubah Artikel</h2>
                <input type="hidden" name="id_Data" value="<?php echo $_GET['id_Data'] ?>" />
                <label>Jumlah lulus<input type="text" name="Data_one" value="<?php echo $_GET['Data_one'] ?>" /></label> <br>
                <label>Jumlah tidak lulus <input type="text" name="Data_two" value="<?php echo $_GET['Data_two'] ?>" /></label> <br>
                <label>Jumlah uji emisi <input type="text" name="Data_Three" value="<?php echo $_GET['Data_Three'] ?>" /></label> <br>
                <label>Bahan bakar <textarea name="Tipe_bahan"><?php echo $_GET['Tipe_bahan'] ?></textarea></label><br>
                <label>Gambar_data Artikel <input type="file" name="Gambar_data" accept="image/*" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_ubah" value="Simpan Perubahan" />
                    atau <a href="cruddata.php?aksi=delete&id_Data=<?php echo $_GET['id_Data'] ?>"> (x) Hapus data ini</a>!
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
    if (isset($_GET['id_Data']) && isset($_GET['aksi'])) {
        $id = $_GET['id_Data'];
        $sql_hapus = "DELETE FROM artikeldata WHERE id_Data=" . $id;
        $hapus = mysqli_query($conn, $sql_hapus);

        if ($hapus) {
            if ($_GET['aksi'] == 'delete') {
                header('location: cruddata.php');
            }
        }
    }

}


// --- Program Utama
if (isset($_GET['aksi'])) {
    switch ($_GET['aksi']) {
        case "create":
            echo '<a href="cruddata.php"> &laquo; Home</a>';
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