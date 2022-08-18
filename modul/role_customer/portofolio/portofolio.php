<?php
include("config/koneksi.php");

require('config/function.php');
$idCustData = $_SESSION['role'];
$portofolio = viewDataPortofolio("SELECT * FROM portofolio WHERE id_customer = '$idCustData'");



// TAMBAH DATA
if (isset($_POST['submit'])) {
    if (tambahData($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan');
        </script>";
        header('Location: dashboardCustomers.php?page=portofolio');
    } else {
        echo "<script>
        alert('Data tidak berhasil ditambahkan');
    </script>";
    }
}


?>


<div id="portofolio">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" id='id' name="id" value="<?php $idCustData; ?>"><br><br>
        <label for="judul">Judul Portofolio</label><br>
        <input type="text" id='judul' name="judul" placeholder="judul portofolio"><br><br>
        <label for="deskripsi">Deskripis Portofolio</label><br>
        <textarea id="deskripsi" name="deskripsi" placeholder="deskripsi portofolio" rows="5" cols="40"></textarea><br><br>
        <label for="thumbnail">Thumbnail</label><br>
        <input type="file" id='thumbnail' name="thumbnail"><br><br>
        <label for="lampiran">Lampiran file</label><br>
        <input type="file" id='lampiran' name="lampiran"><br><br>
        <button type="submit" name="submit">submit</button>
    </form>

    <?php foreach ($portofolio as $port) : ?>
        <div class="card" style="width: 18rem;">
            <img src="file/thumbnail/<?= $port['thumbnail']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $port['judul_portofolio']; ?></h5>
                <p class="card-text"><?= $port['deskripsi']; ?></p>
            </div>
            <div class="card-body">
                <a href="?page=portofolio&action=edit&id=<?= $port['id_portofolio']; ?>" class="card-link">Ubah</a>
                <a href="?page=portofolio&action=hapus&id=<?= $port['id_portofolio']; ?>" class="card-link">Hapus</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>