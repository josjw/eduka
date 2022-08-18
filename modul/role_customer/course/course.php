<?php
require('config/function.php');
$listCourse = viewListCourse("SELECT * FROM Course");

?>

<div id="course">
    <?php foreach ($listCourse as $crs) : ?>
        <div class="card" style="width: 18rem;">
            <img src="file/thumbnail/<?= $crs['thumbnail']; ?>" class="card-img-top" alt="">
            <!-- <img src="file/tmb.jpg" class="card-img-top" alt=""> -->
            <div class="card-body">
                <h5 class="card-title"><?= $crs['judul_course']; ?></h5>
                <p class="card-text"><?= $crs['deskripsi_course']; ?></p>
                <p class="card-text">Harga : <?= $crs['harga']; ?></p>
            </div>
            <div class="card-body">
                <a href="?page=course&action=tambah&id=<?= $crs['id_course']; ?>" class="card-link">Pilih</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>