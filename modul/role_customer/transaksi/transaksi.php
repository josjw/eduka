<?php
include("config/koneksi.php");

require('config/function.php');
$idCustData = $_SESSION['role'];
$portofolio = viewDataTransaksi("SELECT transaksi.id_transaksi, transaksi.id_customer, course.judul_course, ");

?>


<div class="transaksi">
    <h1>TRANSAKSI</h1>

    <table id="dataTable" cellspacing="0" class="table">
        <thead class="table-dark">
            <tr>
                <th>Id Transaksi</th>
                <th>Id Course</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Tanggal</th>
                <th>Status</th>
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