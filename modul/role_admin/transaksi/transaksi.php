<?php
include("config/koneksi.php");

$queryTransaksi = "SELECT * FROM transaksi";
$resultTransaksi = mysqli_query($conn, $queryTransaksi);
$rowsTransaksi = mysqli_num_rows($resultTransaksi);

$columns = array('jumlah', 'total', 'tanggal');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$querySorting = ("SELECT * FROM transaksi ORDER BY " . $column . " " . $sort_order);
$resultSorting = mysqli_query($conn, $querySorting);

if ($resultSorting) {
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
}

// fetch data dari db tabel transaksi where kolom tanggalnya = tanggal hari ini
$dateNow = date("Y-m-d");
$queryTotalToday = "SELECT SUM(total) AS total FROM transaksi WHERE tanggal = '$dateNow'";
$resultTotalToday = mysqli_query($conn, $queryTotalToday);
$rowTotalToday = mysqli_fetch_assoc($resultTotalToday);
$totalToday = $rowTotalToday['total'];

?>

<div id="transaksi">
    <h3>Data Transaksi</h3>
    <h2>Jumlah Transaksi</h2>
    <b><?php echo $rowsTransaksi; ?> Transaksi</b> </br>

    <h2>Jumlah Transaksi Hari ini</h2>
    <b><?php echo $totalToday; ?> Transaksi</b> </br>

    <table id="dataTable" cellspacing="0" class="table">
        <thead class="table-dark">
            <tr>
                <th>Id Transaksi</th>
                <th>Id Customer</th>
                <th>Id Course</th>
                <th><a href="?page=transaksi&column=jumlah&order=<?php echo $asc_or_desc; ?>">Jumlah<i class="fas fa-sort<?php echo $column == 'jumlah' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                <th><a href="?page=transaksi&column=total&order=<?php echo $asc_or_desc; ?>">Total<i class="fas fa-sort<?php echo $column == 'total' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                <th><a href="?page=transaksi&column=tanggal&order=<?php echo $asc_or_desc; ?>">Tanggal<i class="fas fa-sort<?php echo $column == 'tanggal' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM customer";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_array($resultSorting)) {
            ?>
                <tr>
                    <td> <?php echo $data['id_transaksi']; ?> </td>
                    <td> <?php echo $data['id_customer']; ?> </td>
                    <td> <?php echo $data['id_course']; ?> </td>
                    <td> <?php echo $data['jumlah']; ?> </td>
                    <td> <?php echo $data['total']; ?> </td>
                    <td> <?php echo $data['tanggal']; ?> </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>