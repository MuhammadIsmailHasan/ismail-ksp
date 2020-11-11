<?php
    include "koneksi.php";

    $id = isset($_POST['id']) ? mysqli_escape_string($con, $_POST['id']) : '-';
    $nama = mysqli_escape_string($con, $_POST['nama']);
    $awal = mysqli_escape_string($con, $_POST['awal']);
    $akhir = mysqli_escape_string($con, $_POST['akhir']);
    $aktif = mysqli_escape_string($con, $_POST['aktif']);

    if ($aktif == 1) {
        $qry = "UPDATE periode SET aktif = 0";
        mysqli_query($con, $qry) or die (mysqli_error($con));
    }

    if ($id == '-') {
        $qry = "INSERT INTO periode (nama, awal, akhir, aktif)
                VALUES ('$nama', '$awal', '$akhir', '$aktif')";
        mysqli_query($con, $qry) or die (mysqli_error($con));
    } else {
        $qry = "UPDATE periode
                   SET nama = '$nama',
                       awal = '$awal',
                       akhir = '$akhir',
                       aktif = '$aktif'
                 WHERE id = $id";
        mysqli_query($con, $qry) or die (mysqli_error($con));
    }
    
    header('Location: set_periode.php');
?>