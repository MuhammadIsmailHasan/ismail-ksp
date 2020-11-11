<?php
include 'koneksi.php';
include 'functions.php';

$id = mysqli_escape_string($con, $_GET['id']);
$status = mysqli_escape_string($con, $_GET['status']);
if ($status == 'pengajuan') {
    $sql = "UPDATE pinjaman SET status = 'diterima' WHERE id = '$id'";
    mysqli_query($con, $sql) or die(mysqli_error(($con)));
} else if ($status == 'diterima') {
    $tgl = date("Y-m-d");
    $sql_update = "UPDATE pinjaman 
                    SET status = 'selesai', 
                        tgl_acc = '$tgl' 
                    WHERE id = '$id'";
    mysqli_query($con, $sql_update) or die(mysqli_error(($con)));

    // save into pembayaran_pinjaman
    $data = getPinjamanById($con, $id);
    $angsuran = $data['lama_pinjaman'];
    $cicilan = $data['cicilan_per_bulan'];
    $cicilan_awal = date('Y-m-d', strtotime("+1 month", strtotime($tgl)));
    $cicilan_akhir = date('Y-m-d', strtotime("+" . $angsuran . " month", strtotime($tgl)));
    $i = 1;
    while ($cicilan_awal <= $cicilan_akhir) {
        $sql_pembayaran = "INSERT INTO pembayaran_pinjaman (pinjaman_id, jatuh_tempo, angsuran_ke, jumlah, denda, status)
                            VALUES ('$id', '$cicilan_awal', '$i', '$cicilan', '0', '0' )";
        mysqli_query($con, $sql_pembayaran) or die(mysqli_error($con));
        $cicilan_awal = date('Y-m-d', strtotime("+1 month", strtotime($cicilan_awal)));
        $i++;
    }
}

header('location:trans_pinjaman.php');
