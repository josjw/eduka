<?php

// fetch data dari db sesuai session yang tersedia
$query = "SELECT * FROM admin WHERE id_admin ='$_SESSION[role]'";
$result = mysqli_query($conn, $query);
$fetch = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            padding: 0;
            box-sizing: border-box;
        }

        #course {
            height: auto;
            width: auto;
            padding: 20px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
    </style>

</head>

<body>
    <div class="d-flex flex-row">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">Sidebar</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="?" class="nav-link active">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="?page=transaksi" class="nav-link link-dark">
                        Transaksi
                    </a>
                </li>
                <li>
                    <a href="?page=course" class="nav-link link-dark">
                        Tabel Course
                    </a>
                </li>
                <li>
                    <a href="?page=data_admin" class="nav-link link-dark">
                        Tabel Admin
                    </a>
                </li>
                <li>
                    <a href="?page=data_customer" class="nav-link link-dark">
                        Tabel Customers
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo $fetch['nama']; ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">