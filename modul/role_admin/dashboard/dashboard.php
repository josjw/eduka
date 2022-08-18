<?php
include("config/koneksi.php");
if (!isset($_SESSION['role'])) {
    header('location:index.php');
}

// fetch data dari db tabel transaksi where kolom tanggalnya = tanggal hari ini
$dateNow = date("Y-m-d");
$queryTotalToday = "SELECT SUM(total) AS total FROM transaksi WHERE tanggal = '$dateNow'";
$resultTotalToday = mysqli_query($conn, $queryTotalToday);
$rowTotalToday = mysqli_fetch_assoc($resultTotalToday);
$totalToday = $rowTotalToday['total'];


// fetch data dari db tabel transaksi where tanggalnya 1bulan sebelumnya hingga hari ini
$datePrevMonth = date('Y-m-d', strtotime('-1 month', time()));
// $queryTotalPrevMonth = "SELECT SUM(total) AS total FROM transaksi WHERE tanggal BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
$queryTotalPrevMonth = "SELECT SUM(total) AS total FROM transaksi WHERE tanggal >= '$datePrevMonth' AND  tanggal <= '$dateNow'";
$resultTotalPrevMonth = mysqli_query($conn, $queryTotalPrevMonth);
$rowPrevMonth = mysqli_fetch_assoc($resultTotalPrevMonth);
$totalPrevMonth = $rowPrevMonth['total'];

?>
<div id="dashboard">

    <div>
        <h2>Penghasilan (Hari ini)</h2>
        <b>Rp <?php echo $totalToday; ?></b>

        <h2>Penghasilan (Bulan ini)</h2>
        <b><?php echo $datePrevMonth; ?> <u> hingga</u> <?php echo $dateNow; ?></b> <br>
        <b>Rp <?php echo $totalPrevMonth; ?></b>

    </div>

    <!-- <h3>Data Adminds</h3>
    <table id="dataTable" cellspacing="0" class="table">
        <thead class="table-dark">
            <tr>
                <th>Id_admin</th>
                <th>Email</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM admin";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td> <?php echo $data['id_admin']; ?> </td>
                    <td> <?php echo $data['email']; ?> </td>
                    <td> <?php echo $data['nama']; ?> </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table> -->
</div>