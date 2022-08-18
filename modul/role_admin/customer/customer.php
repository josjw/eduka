<?php
include("config/koneksi.php");
$error = '';

$queryCustomer = "SELECT * FROM customer";
$resultCustomer = mysqli_query($conn, $queryCustomer);
$rowsCustomer = mysqli_num_rows($resultCustomer);

$columns = array('nama_customer', 'gender', 'course', 'portofolio', 'saldo');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$querySorting = ("SELECT * FROM customer ORDER BY " . $column . " " . $sort_order);
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
        $idCustomer = $_GET['id'];
        $queryDelete = "DELETE FROM customer WHERE id_customer = '$idCustomer'";
        $resultDelete = mysqli_query($conn, $queryDelete);

        $queryUpdateId = "UPDATE transaksi SET id_customer = 'DEL' WHERE id_customer ='$idCustomer'";
        $resultUpdateId = mysqli_query($conn, $queryUpdateId);
        header('Location: dashboardAdmin.php?page=data_customer');
    }

    if (preg_match("/edit/", $_GET['action'])) {
        $clasShow = true;
        $idForm = $_GET['id'];
        $queryCustomer = "SELECT * FROM customer WHERE id_customer = '$idForm'";
        $resultCustomer = mysqli_query($conn, $queryCustomer);
        $dataCustomer = mysqli_fetch_array($resultCustomer);

        if (isset($_POST['update'])) {
            $newNama = $_POST['nama'];
            $newEmail = $_POST['email'];
            $newAlamat = $_POST['alamat'];
            $newTelepon = $_POST['telepon'];
            $newDummySaldo = $_POST['dummy_saldo'];

            $query = "UPDATE customer SET nama_customer = '$newNama', email = '$newEmail', alamat = '$newAlamat', telepon = '$newTelepon', saldo = '$newDummySaldo' WHERE id_customer = '$idForm'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                header('Location: dashboardAdmin.php?page=data_customer');
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

            $alamat = $_POST['alamat'];
            $alamat = mysqli_real_escape_string($conn, $alamat);

            $telepon = $_POST['telepon'];

            $new_date = date('Y-m-d', strtotime($_POST['date']));

            $jenis_kelamin = $_POST['jenis_kelamin'];

            $dummy_saldo = $_POST['dummy_saldo'];

            if (!empty(trim($email)) && !empty(trim($password)) && !empty(trim($nama_lengkap)) && !empty(trim($alamat)) && !empty(trim($telepon)) && !empty(trim($new_date)) && !empty(trim($jenis_kelamin)) && !empty(trim($dummy_saldo))) {
                if (cek_email($email, $conn) === 0) {
                    $idKeyuser = cek_idCustomer($conn);

                    $query = "INSERT INTO customer (id_customer, email, password, nama_customer, alamat, telepon, tanggal, gender, saldo) VALUES ('$idKeyuser', '$email', '$password', '$nama_lengkap', '$alamat', '$telepon', '$new_date', '$jenis_kelamin', '$dummy_saldo')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        header('Location: dashboardAdmin.php?page=data_customer');
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
    $query = "SELECT * FROM customer WHERE email = '$email'";
    if ($result = mysqli_query($conn, $query)) return mysqli_num_rows($result);
}

function cek_idCustomer($conn)
{
    $key = 'C' . substr(uniqid(rand(), true), 4, 4);

    $key = mysqli_real_escape_string($conn, $key);
    $query = "SELECT * FROM customer WHERE id_customer = '$key'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);

    if ($rows === 0) {
        return $key;
    } else {
        return cek_idCustomer($conn);
    }
}

?>
<div id="customer">
    <h3>Data Customer</h3>
    <h2>Jumlah Customer</h2>
    <b><?php echo $rowsCustomer; ?> Account</b>
    <a href="?page=data_customer&action=tambah" class="btn btn-info">
        <span class="text">Tambah Data</span>
    </a>
    <!-- tabelCustomer.php?action=edit&id= -->

    <div class="form-edit" <?php if ($clasShow === false) { ?>style="display:none" <?php } ?>>
        <h3><u>form edit data</u></h3>
        <form action="" method="POST">
            <input type="text" name="nama" placeholder="nama anda" value="<?php echo $dataCustomer['nama_customer']; ?>">
            <input type="email" name="email" placeholder="email anda" value="<?php echo $dataCustomer['email']; ?>">
            <input type="text" name="alamat" placeholder="alamat anda" value="<?php echo $dataCustomer['alamat']; ?>">
            <input type="number" name="telepon" placeholder="nomer telepon" maxlength="13" value="<?php echo $dataCustomer['telepon']; ?>">
            <input type="number" name="dummy_saldo" placeholder="dummy saldo" value="<?php echo $dataCustomer['saldo']; ?>">
            <input type="submit" name="update" value="Update">
            <a href="dashboardAdmin.php?page=data_customer" class="btn btn-info">
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
            <input type="text" name="alamat" placeholder="alamat lengkap">
            <input type="number" name="telepon" placeholder="nomer telepon" maxlength="13">
            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
            <input type="radio" id="l" name="jenis_kelamin" value="L">
            <label for="l">L</label>
            <input type="radio" id="p" name="jenis_kelamin" value="P">
            <label for="p">P</label>
            <input type="number" name="dummy_saldo" placeholder="dummy saldo">
            <button type="submit" name="tambah">Tambah</button>
            <a href="dashboardAdmin.php?page=data_customer" class="btn btn-info">
                <span class="text">Cancel</span>
            </a>
        </form>
    </div>

    <!-- <?php echo $action; ?> -->

    <table id="dataTable" cellspacing="0" class="table">
        <thead class="table-dark">
            <tr>
                <th>Id Customer</th>
                <th><a href="?page=data_customer&column=nama&order=<?php echo $asc_or_desc; ?>">Nama<i class="fas fa-sort<?php echo $column == 'nama_customer' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                <th>Email</th>
                <th><a href="?page=data_customer&column=gender&order=<?php echo $asc_or_desc; ?>">Jenis Kelamin<i class="fas fa-sort<?php echo $column == 'gender' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                <th>Alamat</th>
                <th>Tanggal</th>
                <th>Telepon</th>
                <th><a href="?page=data_customer&column=saldo&order=<?php echo $asc_or_desc; ?>">Saldo<i class="fas fa-sort<?php echo $column == 'saldo' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM customer";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_array($resultSorting)) {
            ?>
                <tr>
                    <td> <?php echo $data['id_customer']; ?> </td>
                    <td> <?php echo $data['nama_customer']; ?> </td>
                    <td> <?php echo $data['email']; ?> </td>
                    <td> <?php echo $data['gender']; ?> </td>
                    <td> <?php echo $data['alamat']; ?> </td>
                    <td> <?php echo $data['tanggal']; ?> </td>
                    <td> <?php echo $data['telepon']; ?> </td>
                    <td> <?php echo $data['saldo']; ?> </td>
                    <td>
                        <a href="?page=data_customer&action=edit&id=<?php echo $data['id_customer']; ?>" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                            <span class="text">Edit</span>
                        </a>
                        <a href="?page=data_customer&action=delete&id=<?php echo $data['id_customer']; ?>" class="btn btn-danger btn-icon-split">
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