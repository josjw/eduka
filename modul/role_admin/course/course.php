<?php
include("config/koneksi.php");

require('config/function.php');
$courses = viewListCourse("SELECT * FROM course");



if (isset($_POST['submit'])) {
    if (addCourse($_POST) > 0) {
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href = 'dashboardAdmin.php?page=course';
</script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Unsuccesfully Updated');
    window.location.href = 'dashboardAdmin.php?page=course';
</script>");
    }
}
?>

<div id="course">
<h1>Add Course</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" id='id' name="id" value="<?php $idCust; ?>"><br><br>
        <label for="judul">Judul Portofolio</label><br>
        <input type="text" id='judul' name="judul" placeholder="judul portofolio"><br><br>
        <label for="deskripsi">Deskripis Portofolio</label><br>
        <textarea id="deskripsi" name="deskripsi" placeholder="deskripsi portofolio" rows="5" cols="40"></textarea><br><br>
        <label for="harga">Harga</label><br>
        <input type="text" id='harga' name="harga" placeholder="Harga"><br><br>
        <label for="thumbnail">Thumbnail</label><br>
        <input type="file" id='thumbnail' name="thumbnail"><br><br>
        <button type="submit" name="submit">submit</button>
    </form>
        <?php foreach ($courses as $course) : ?>
            <div class="card" style="width: 18rem;">
                <img src="file/thumbnail/<?= $course['thumbnail']; ?>" class="card-img-top" alt="">
                <!-- <img src="file/tmb.jpg" class="card-img-top" alt=""> -->
                <div class="card-body">
                    <h5 class="card-title"><?= $course['judul_course']; ?></h5>
                    <p class="card-text"><?= $course['deskripsi_course']; ?></p>
                    <p class="card-text">Harga : <?= $course['harga']; ?></p>
                </div>
                <div class="card-body">
                    <a href="?page=course&action=hapus&id=<?= $course['id_course']; ?>" class="card-link">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>
</div>
<button onclick="location.href='dashboardAdmin.php'">Kembali</button>

</div>