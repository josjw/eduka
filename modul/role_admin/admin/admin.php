<?php
include("config/koneksi.php");
$error = '';

$queryAdmin = "SELECT * FROM admin";
$resultAdmin = mysqli_query($conn, $queryAdmin);
$rowsAdmin = mysqli_num_rows($resultAdmin);

$columns = array('id_admin', 'nama_admin', 'email');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$querySorting = ("SELECT * FROM admin ORDER BY " . $column . " " . $sort_order);
$resultSorting = mysqli_query($conn, $querySorting);

if ($resultSorting) {
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
}




$action = isset($_GET['action']) == 'edit' ? 'edit' : 'delete';

$clasShow = false;
$clasTambahShow = false;


if (isset($_GET['action'])) {
    if (preg_match("/delete/", $_GET['action'])) {
        $idAdmin = $_GET['id'];
        $queryDelete = "DELETE FROM admin WHERE id_admin = '$idAdmin'";
        $resultDelete = mysqli_query($conn, $queryDelete);
        header('Location: dashboardAdmin.php?page=data_admin');
    }

    if (preg_match("/edit/", $_GET['action'])) {
        $clasShow = true;
        $idForm = $_GET['id'];
        $queryEdit = "SELECT * FROM admin WHERE id_admin = '$idForm'";
        $resultEdit = mysqli_query($conn, $queryEdit);
        $dataEdit = mysqli_fetch_array($resultEdit);

        if (isset($_POST['update'])) {
            $newNama = $_POST['nama'];
            $newEmail = $_POST['email'];

            $query = "UPDATE admin SET nama = '$newNama', email = '$newEmail' WHERE id_admin = '$idForm'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                header('Location: dashboardAdmin.php?page=data_admin');
                exit;
            }
        }
    }

    if (preg_match("/tambah/", $_GET['action'])) {
        $clasTambahShow = true;

        if (isset($_POST['tambah'])) {
            $email = $_POST['email'];
            $email = mysqli_real_escape_string($conn, $email);

            $password = $_POST['password'];
            $password = mysqli_real_escape_string($conn, $password);

            $nama_lengkap = $_POST['nama_lengkap'];
            $nama_lengkap = mysqli_real_escape_string($conn, $nama_lengkap);


            if (!empty(trim($email)) && !empty(trim($password)) && !empty(trim($nama_lengkap))) {
                if (cek_email($email, $conn) === 0) {
                    $idAdmin = cek_idAdmin($conn);

                    $query = "INSERT INTO admin (id_admin, email, password, nama) VALUES ('$idAdmin', '$email', '$password', '$nama_lengkap')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        header('Location: dashboardAdmin.php?page=data_admin');
                    } else {
                        $error = "Tambah data gagal";
                    }
                } else {
                    $error = "email sudah digunakan";
                }
            } else {
                $error = "form tidak boleh kosong";
            }
        }
    }
}

function cek_email($email, $conn)
{
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM admin WHERE email = '$email'";
    if ($result = mysqli_query($conn, $query)) return mysqli_num_rows($result);
}

function cek_idAdmin($conn)
{
    $key = 'A' . substr(uniqid(rand(), true), 4, 4);

    $key = mysqli_real_escape_string($conn, $key);
    $query = "SELECT * FROM admin WHERE id_admin = '$key'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);

    if ($rows === 0) {
        return $key;
    } else {
        return cek_idAdmin($conn);
    }
}

?>
<div id="customer">
    <h3>Data Admin</h3>
    <h2>Jumlah Admin</h2>
    <b><?php echo $rowsAdmin; ?> Account</b>
    <a href="?page=data_admin&action=tambah" class="btn btn-info">
        <span class="text">Tambah Data</span>
    </a>
    <!-- tabelCustomer.php?action=edit&id= -->

    <div class="form-edit" <?php if ($clasShow === false) { ?>style="display:none" <?php } ?>>
        <h3><u>form edit data</u></h3>
        <form action="" method="POST">
            <input type="text" name="nama" placeholder="nama anda" value="<?php echo $dataEdit['nama']; ?>">
            <input type="email" name="email" placeholder="email anda" value="<?php echo $dataEdit['email']; ?>">
            <input type="submit" name="update" value="Update">
            <a href="dashboardAdmin.php?page=data_admin" class="btn btn-info">
                <span class="text">Cancel</span>
            </a>
        </form>
    </div>

    <div class="form-tambah" <?php if ($clasTambahShow === false) { ?>style="display:none" <?php } ?>>
        <h3><u>form tambah data</u></h3>
        <form method="POST" action="">
            <?php if ($error != '') { ?>
                <h1>Error : <?= $error; ?></h1>
            <?php } ?>
            <input type="email" name="email" placeholder="email anda">
            <input type="password" name="password" placeholder="password anda">
            <input type="text" name="nama_lengkap" placeholder="nama lengkap">
            <button type="submit" name="tambah">Tambah</button>
            <a href="dashboardAdmin.php?page=data_admin" class="btn btn-info">
                <span class="text">Cancel</span>
            </a>
        </form>
    </div>

    <!-- <?php echo $action; ?> -->

    <table id="dataTable" cellspacing="0" class="table">
        <thead class="table-dark">
            <tr>
                <th>Id Customer</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM admin";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_array($resultSorting)) {
            ?>
                <tr>
                    <td> <?php echo $data['id_admin']; ?> </td>
                    <td> <?php echo $data['nama']; ?> </td>
                    <td> <?php echo $data['email']; ?> </td>
                    <td>
                        <a href="?page=data_admin&action=edit&id=<?php echo $data['id_admin']; ?>" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                            <span class="text">Edit</span>
                        </a>
                        <a href="?page=data_admin&action=delete&id=<?php echo $data['id_admin']; ?>" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Hapus</span>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>