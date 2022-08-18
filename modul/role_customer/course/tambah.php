<?php 
require('config/function.php');
$eror = "Course sudah dipilih";
$done = "Course berhasil ditambahkan";


$id = $_GET['id'];

if( pilihCourse($id) > 0 ){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='dashboardCustomers.php';
    </script>");
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Unsuccesfully Updated');
    window.location.href='dashboardCustomers.php';
    </script>");
}
