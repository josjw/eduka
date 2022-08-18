<?php
session_start();
if (!isset($_SESSION['role'])) {
    header('location:index.php');
}
?>

<?php include("config/koneksi.php"); ?>

<?php include("template/header.php"); ?>

<?php include("contentCustomer.php"); ?>

<?php include("template/footer.php"); ?>