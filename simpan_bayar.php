<?php
include 'koneksi.php';
$id = $_POST['id_bayar'];
$denda = $_POST['denda_bayar'];
$nik = $_POST['nik'];
$tgl = date('Y-m-d');
$qry = "UPDATE pembayaran_pinjaman 
            SET status = 1, 
            tgl_pembayaran = '$tgl',
            denda = '$denda' 
            WHERE id = '$id'";
mysqli_query($con, $qry) or die(mysqli_error($con));

header("location:trans_pinjaman_bayar.php?nik=$nik");
