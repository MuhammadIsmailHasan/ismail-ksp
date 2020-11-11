<?php
header("Access-Control-Allow-Origin: *");
include "../koneksi.php";

$data = [];
$nik = isset($_GET['nik']) ? mysqli_escape_string($con, $_GET['nik']) : null;
if ($nik == null) {
    $qry = "SELECT p.*, a.nama as nama_anggota
            FROM pinjaman p 
            INNER JOIN anggota a 
            ON p.anggota_id = a.id";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $data_pinjaman = [];
    while ($pinjaman = mysqli_fetch_assoc($sql)) {
        array_push($data_pinjaman, $pinjaman);
    }
    $data['list pinjaman'] = $data_pinjaman;
} else {
    $qry = "SELECT p.*, a.nama as nama_anggota
            FROM pinjaman p 
            INNER JOIN anggota a 
            ON p.anggota_id = a.id 
        WHERE a.nik = '$nik'";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $pinjaman = mysqli_fetch_assoc($sql);
    $data['detail pinjaman'] = $pinjaman;
}

echo json_encode($data);
