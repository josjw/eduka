<?php
session_start();
if (!isset($_SESSION['role'])) {
    header('location:index.php');
}
?>

<?php include("config/koneksi.php"); ?>

<?php include("template/sidebar.php"); ?>

<?php include("contentAdmin.php"); ?>

<?php include("template/footer.php"); ?>