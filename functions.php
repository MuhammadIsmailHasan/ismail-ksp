<?php
function getPeriodeAktif($con)
{
    $qry = "SELECT * FROM periode WHERE aktif = 1";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi = mysqli_fetch_assoc($sql);

    return $isi['id'];
}

function getAkhirPeriodeAktif($con)
{
    $qry = "SELECT * FROM periode WHERE aktif = 1";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi = mysqli_fetch_assoc($sql);

    return $isi['akhir'];
}
function getPinjamanById($con, $id)
{
    $qry = "SELECT * FROM pinjaman WHERE id = '$id'";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $data = mysqli_fetch_assoc($sql);

    return $data;
}
