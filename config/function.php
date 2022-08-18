<?php

function tambahData($data)
{
    $idCust = $_SESSION['role'];
    global $conn;
    $judulPortofolio = htmlspecialchars($data['judul']);
    $deskripsiPortofolio = htmlspecialchars($data['deskripsi']);
    $thumbnail = uploadThumbnail();

    if (!$thumbnail) {
        return false;
    }

    $lampiran = uploadLampiran();
    if (!$lampiran) {
        return false;
    }
    $key = 'P' . substr(uniqid(rand(), true), 4, 4);

    $query = "INSERT INTO portofolio VALUES('$key','$idCust','$judulPortofolio','$deskripsiPortofolio','$thumbnail','$lampiran')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function addCourse($data)
{
    global $conn;
    $judulCourse = htmlspecialchars($data['judul']);
    $deskripsiCourse = htmlspecialchars($data['deskripsi']);
    $hargaCourse = htmlspecialchars($data['harga']);
    $thumbnail = uploadThumbnail();

    if (!$thumbnail) {
        return false;
    }
 
    $key = 'IC' . substr(uniqid(rand(), true), 3, 3);

    $kuery = "INSERT INTO course VALUES ('$key', '$judulCourse', '$deskripsiCourse','$hargaCourse', '$thumbnail')";
    mysqli_query($conn, $kuery);
    return mysqli_affected_rows($conn);
}
function ubahDataPortofolio($data)
{
    $idCust = $_SESSION['role'];
    global $conn;
    $idPort = htmlspecialchars($data['id']);
    $judulPortofolio = htmlspecialchars($data['judul']);
    $deskripsiPortofolio = htmlspecialchars($data['deskripsi']);
    $thumbnail = uploadThumbnail();

    if (!$thumbnail) {
        return false;
    }

    $lampiran = uploadLampiran();
    if (!$lampiran) {
        return false;
    }
    $key = 'P' . substr(uniqid(rand(), true), 4, 4);

    $query = "  UPDATE portofolio SET
                judul_portofolio = '$judulPortofolio',
                deskripsi = '$deskripsiPortofolio',
                WHERE id_portofolio = '$idPort'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function uploadThumbnail()
{
    $dirThumbnails = 'file/thumbnail/';
    $namaThumbnail = $_FILES['thumbnail']['name'];
    $ukuranThumbnail = $_FILES['thumbnail']['size'];
    $errorThumbnail = $_FILES['thumbnail']['error'];
    $tmpThumbnail = $_FILES['thumbnail']['tmp_name'];

    //cek apakah ada gambar yang diupload
    if ($errorThumbnail === 4) {
        echo "<script>
        alert('Data tidak berhasil ditambahkan');
            </script>";
        return false;
    }

    //cek apakah benar gambar yang diupload
    $ekstensiThumbnailValid = ['jpg', 'jpeg', 'png'];
    $ekstensiThumbnail = explode('.', $namaThumbnail);
    $ekstensiThumbnail = strtolower(end($ekstensiThumbnail));
    if (!in_array($ekstensiThumbnail, $ekstensiThumbnailValid)) {
        echo "<script>
        alert('Data yang diupload bukan gambar');
            </script>";
        return false;
    }

    //cek apakah ukuran gambar sesuai
    if ($ukuranThumbnail > 50000000) {
        echo "<script>
        alert('gambar yang diupload terlalu besar, maksimal 10mb');
            </script>";
        return false;
    }

    //nama file baru
    $namaFileThumbnailBaru = uniqid();
    $namaFileThumbnailBaru .= '.';
    $namaFileThumbnailBaru .= $ekstensiThumbnail;

    //memindahkan gambar dari temporari ke folder
    move_uploaded_file($tmpThumbnail, $dirThumbnails . $namaFileThumbnailBaru);

    return $namaFileThumbnailBaru;
}
function uploadLampiran()
{
    $defaultThumbnail = '../file/default.jpg';
    $dirLampiran = 'file/';
    $namaLampiran = $_FILES['lampiran']['name'];
    $ukuranLampiran = $_FILES['lampiran']['size'];
    $errorLampiran = $_FILES['lampiran']['error'];
    $tmpLampiran = $_FILES['lampiran']['tmp_name'];

    //cek apakah ada lampuran yang diupload
    if ($errorLampiran === 4) {
        echo "<script>
        alert('Data tidak berhasil ditambahkan');
            </script>";
        return false;
    }

    //cek ekstensi lampiran yang diupload
    $ekstensiLampiranlValid = ['jpg', 'jpeg', 'png', 'pdf', 'rar', 'zip', 'psd', 'ai'];
    $ekstensiLampiran = explode('.', $namaLampiran);
    $ekstensiLampiran = strtolower(end($ekstensiLampiran));
    if (!in_array($ekstensiLampiran, $ekstensiLampiranlValid)) {
        echo "<script>
        alert('mohon upload sesuai ketentuan');
            </script>";
        return false;
    }

    //cek apakah ukuran lampiran sesuai
    if ($ukuranLampiran > 300000000) {
        echo "<script>
        alert('gambar yang diupload terlalu besar, maksimal 300mb');
            </script>";
        return false;
    }

    //nama file lampiran baru
    $namaLampiranBaru = uniqid();
    $namaLampiranBaru .= '.';
    $namaLampiranBaru .= $ekstensiLampiran;

    //memindahkan lampiran dari temporari ke folder
    move_uploaded_file($tmpLampiran, $dirLampiran . $namaLampiranBaru);

    return $namaLampiranBaru;
}
function viewDataTransaksi($dataPortofolio)
{
    global $conn;
    $result = mysqli_query($conn, $dataPortofolio);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function viewDataPortofolio($dataPortofolio)
{
    global $conn;
    $result = mysqli_query($conn, $dataPortofolio);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function hapusPortofolio($idPorto)
{
    global $conn;
    $hapusQuery = "DELETE FROM portofolio WHERE id_portofolio = '$idPorto'";
    mysqli_query($conn, $hapusQuery);
    return mysqli_affected_rows($conn);
}
function viewListCourse($dataCourse)
{
    global $conn;
    $result = mysqli_query($conn, $dataCourse);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function viewDataCourse($Course)
{
    global $conn;
    $result = mysqli_query($conn, $Course);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function hapusCourses($idCoureses){
    global $conn;
    $hapusQuery = "DELETE FROM course WHERE id_course = '$idCoureses'";
    mysqli_query($conn, $hapusQuery);
    return mysqli_affected_rows($conn);
}
// function pilihCourse($idCourse)
// {
//     global $conn;
//     $idCust = $_SESSION['role'];
//     $key = 'CH' . substr(uniqid(rand(), true), 3, 3);
//     $addCourse = "INSERT INTO pilihcourse VALUES('$key','$idCourse','$idCust')";
//     mysqli_query($conn, $addCourse);

//     return mysqli_affected_rows($conn);
// }

// function pilihCourse($idCourse)
// {
//     global $conn;
//     $idCust = $_SESSION['role'];
//     $key = 'CH' . substr(uniqid(rand(), true), 3, 3);

//     if (cekIDPilCourse($idCourse) === 0) {
//         $addCourse = "INSERT INTO pilihcourse VALUES('$key','$idCourse','$idCust')";
//         mysqli_query($conn, $addCourse);
//         return mysqli_affected_rows($conn);
//     } else {
//         $eror = "Course sudah ada";
//     }
// }
// function cekIDPilCourse($crsID)
// {
//     global $conn;
//     $cek = "SELECT * FROM pilihcourse WHERE id_course = '$crsID'";
//     $result = mysqli_query($conn, $cek);
//     return mysqli_num_rows($result);
// }

function pilihCourse($idCourse)
{
    global $conn;
    $idCust = $_SESSION['role'];
    $key = 'CH' . substr(uniqid(rand(), true), 3, 3);

    //cek id ada atau tidak tidak
    //cek jumlah course by id (maks 3)
    //cek id_course dikolom id_course apakah sama atau tidak
    if (cekIDPilCourse($idCourse) === 0 && cekIdCustomer() === 0) {
        $addCourse = "INSERT INTO pilihcourse VALUES('$key','$idCourse','$idCust')";
        mysqli_query($conn, $addCourse);
        return mysqli_affected_rows($conn);
    } else {
        $eror = "Course sudah ada";
    }
}
function cekIDPilCourse($crsID)
{
    global $conn;
    $cek = "SELECT * FROM pilihcourse WHERE id_course = '$crsID'";
    $result = mysqli_query($conn, $cek);
    return mysqli_num_rows($result);
}
function cekIdCustomer()
{
    global $conn;
    $idCust = $_SESSION['role'];
    $cek = "SELECT * FROM pilihcourse WHERE id_customer = '$idCust'";
    $result = mysqli_query($conn, $cek);
    return mysqli_num_rows($result);
}
