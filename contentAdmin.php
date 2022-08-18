<?php

@$page = $_GET['page'];

if ($page == "transaksi") {
	//tampilkan halaman Dashboard
	//echo "Tampil Halaman Modul Dashboard";
	include "modul/role_admin/transaksi/transaksi.php";
} elseif ($page == "data_customer") {
	//tampilkan halaman transaksi
	include "modul/role_admin/customer/customer.php";
} elseif ($page == "course") {
	//tampilkan halaman transaksi
	if (@$_GET['action'] == "hapus") {
		include "modul/role_admin/course/hapus.php";
	} else {
		include "modul/role_admin/course/course.php";
	}
	
} elseif ($page == "data_admin") {
	//tampilkan halaman transaksi
	// include "modul/admin/admin.php";
	include "modul/role_admin/admin/admin.php";

	// if(@$_GET['action'] == "tambah" || @$_GET['action'] == "edit" || @$_GET['action'] == "delete"){
	// 	include "modul/arsip/form.php";
	// }else{
	// 	include "modul/arsip/data.php";
	// }
} else {
	//echo "Tampil Halaman Home";
	include "modul/role_admin/dashboard/dashboard.php";
}
