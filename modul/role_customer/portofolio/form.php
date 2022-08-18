<?php
require('config/function.php');

$id = $_GET['id'];
$update = viewDataPortofolio("SELECT * FROM portofolio WHERE id_portofolio = '$id'")[0];

if (isset($_GET['action'])) {
    if ($_GET['action'] == "edit") {
        if (isset($_POST['submit'])) {
            if (ubahDataPortofolio($_POST) > 0) {
                echo "<script>
            alert('Data berhasil diubah');
        </script>";
                header('Location: dashboardCustomers.php?page=portofolio');
            } else {
                echo "<script>
        alert('Data tidak berhasil diubah');
    </script>";
            }
        }
    }
    elseif ($_GET['action'] == "hapus") {
        if (hapusPortofolio($id) > 0) {
            echo "<script>
            alert('Data berhasil dihapus');
            document.location.href = 'dashboardCustomers.php?page=portofolio';
            </script>";
        } else {
            echo "<script>
            alert('Data tidak berhasil dihapus');
            document.location.href = 'dashboardCustomers.php?page=portofolio';
            </script>";
        }
    }
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Portofolio</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" id='id' name="id" value="<?php $update['id_portofolio']; ?>"><br><br>
        <label for="judul">Judul Portofolio</label><br>
        <input type="text" id='judul' name="judul" value="<?= $update['judul_portofolio']; ?>"><br><br>
        <label for="deskripsi">Deskripis Portofolio</label><br>
        <textarea id="deskripsi" name="deskripsi" placeholder="<?= $update['deskripsi']; ?>" value="<?= $update['deskripsi']; ?>" rows="5" cols="40"></textarea><br><br>
        <label for="thumbnail">Thumbnail</label><br>
        <input type="file" id='thumbnail' name="thumbnail" value="<?= $update['thumbnail']; ?>"><br><br>
        <label for="lampiran">Lampiran file</label><br>
        <input type="file" id='lampiran' name="lampiran" value="<?= $update['lampiran']; ?>"><br><br>
        <button type="submit" name="submit">Update</button>
    </form>
</body>

</html>