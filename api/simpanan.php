<?php
    header("Access-Control-Allow-Origin: *");
    include "../koneksi.php";

    $data = [];
    $nik = $_GET['nik'];
    $qry = "SELECT a.*, SUM(s.debet) - SUM(s.kredit) as saldo
              FROM anggota a, simpanan s
             WHERE a.id = s.anggota_id
               AND a.nik = '$nik'
             GROUP BY a.id";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi = mysqli_fetch_assoc($sql);

    $qry = "SELECT s.*
              FROM simpanan s, anggota a
             WHERE a.id = s.anggota_id
               AND a.nik = '$nik'";
    $sql_simpanan = mysqli_query($con, $qry) or die(mysqli_error($con));
    $simpanan = [];
    while($isi_simpanan = mysqli_fetch_assoc($sql_simpanan)) {
        array_push($simpanan, $isi_simpanan);
    }
    $data['simpanan'] = $simpanan;

    $qry = "SELECT SUM(b.jumlah) as bunga
              FROM bunga b, simpanan s, anggota a
             WHERE b.simpanan_id = s.id
               AND s.anggota_id = a.id
               AND a.nik = '$nik'";
    $sql_bunga = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi_bunga = mysqli_fetch_assoc($sql_bunga);

    $data['t_simpanan'] = $isi['saldo'];
    $data['t_bunga'] = $isi_bunga['bunga'];

    echo json_encode($data);
?>