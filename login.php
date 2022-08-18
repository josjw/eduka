<?php
include("config/koneksi.php");
session_start();

$error = '';
// Cek session loggedIn, jika terdapat session 'loggedIn' maka return true dan menjalankan if didalamnya
if (isset($_SESSION['loggedIn'])) {
    // Cek apakah session role yang berisikan id_admin dan id_customer
    // jika pada id terdapat huruf A artinya login admin
    if (preg_match("/A/", $_SESSION['role'])) {
        header('Location: dashboardAdmin.php');
    }
    // jika pada id terdapat huruf C artinya login customer
    if (preg_match("/C/", $_SESSION['role'])) {
        header('Location: dashboardCustomers.php');
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn, $email);

    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn, $password);

    // trim untuk menghapus spasi / whitespace string
    if (!empty(trim($email)) && !empty(trim($password))) {

        // cek apakah data inputan form login tersedia di tabel admin
        $queryAdmin = "SELECT * FROM admin WHERE email ='$email' AND password ='$password'";
        $resultAdmin = mysqli_query($conn, $queryAdmin);
        $rowsAdmin = mysqli_num_rows($resultAdmin);
        // mysqli_query = fungsi php untuk menjalankan instruksi atau argumen ke mysql
        // mysqli_num_rows = digunakan untuk mengetahui berapa banyak jumlah baris

        // cek apakah data inputan form login tersedia di tabel customer
        $queryCustomers = "SELECT * FROM customer WHERE email ='$email' AND password ='$password'";
        $resultCustomers = mysqli_query($conn, $queryCustomers);
        $rowsCustomers = mysqli_num_rows($resultCustomers);

        // cek result jumlah baris dari variabel $rowsAdmin
        if ($rowsAdmin != 0) {
            while ($row = mysqli_fetch_assoc($resultAdmin)) {
                // mysqli_fetch_assoc = digunakan untuk mengambil baris hasil sebagai array asosiatif
                $dbEmail = $row['email'];
                $dbPassword = $row['password'];
                $role = $row['id_admin'];
            }
            if ($email == $dbEmail && $password == $dbPassword) {
                session_start();
                $_SESSION['role'] = $role;
                $_SESSION['loggedIn'] = true;
                header('Location: dashboardAdmin.php');
            }
        } elseif ($rowsCustomers != 0) {
            while ($row = mysqli_fetch_assoc($resultCustomers)) {
                $dbEmail = $row['email'];
                $dbPassword = $row['password'];
                $role = $row['id_customer'];
            }
            if ($email == $dbEmail && $password == $dbPassword) {
                session_start();
                $_SESSION['role'] = $role;
                $_SESSION['loggedIn'] = true;
                header('Location: dashboardCustomers.php');
            }
        } else {
            $error = "Data tidak ditemukan, gagal login!";
        }
    } else {
        $error = "Form tidak boleh kosong";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN LOGIN</title>
</head>

<body>
    <h1>LOGINN</h1>
    <form method="POST" action="">
        <?php if ($error != '') { ?>
            <h1>Error : <?= $error; ?></h1>
        <?php } ?>
        <input type="email" name="email" placeholder="email anda">
        <input type="password" name="password" placeholder="password anda">
        <button type="submit" name="submit">Login</button>
    </form>
</body>

</html>