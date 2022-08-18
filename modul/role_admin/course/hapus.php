<?php

require('config/function.php');
$id = $_GET['id'];

if (hapusCourses($id) > 0) {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Deleted');
    window.location.href='dashboardAdmin.php?page=course';
    </script>");
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Unsuccesfully Deleted');
    window.location.href='dashboardAdmin.php?page=course';
    </script>");
}
