<?php
header("Access-Control-Allow-Origin: *");
include "../koneksi.php";

$data = [];
$idUser = isset($_POST['id']) ? mysqli_escape_string($con, $_POST['id']) : null;
$jmlPinjaman = isset($_POST['jumlah']) ? mysqli_escape_string($con, $_POST['jumlah']) : null;
$waktuPinjam = isset($_POST['waktu']) ? mysqli_escape_string($con, $_POST['waktu']) : null;
$halaman = isset($_POST['halaman']) ? mysqli_escape_string($con, $_POST['waktu']) : null;

if ($idUser == null || $jmlPinjaman == null || $waktuPinjam == null) {
    $data['status'] = 'error';
    $data['msg'] = 'Data tidak lengkap';
} else {
    $bunga = 0.02 * $jmlPinjaman;
    $cicilan = round($jmlPinjaman / $waktuPinjam, 0);

    $qry = "INSERT INTO pinjaman (anggota_id, jumlah_pinjaman, lama_pinjaman, bunga_pinjaman, total_pinjaman, cicilan_per_bulan, 
                                  uang_yang_diterima, status)
            VALUES ($idUser, $jmlPinjaman, $waktuPinjam, $bunga, $jmlPinjaman, $cicilan,
                    $jmlPinjaman - $bunga, 'pengajuan')";
    mysqli_query($con, $qry);

    $data['status'] = 'ok';
    $data['msg'] = '';
}

if ($halaman == null) {
    echo json_encode($data);
} else {
    header('Location: ../trans_pinjaman.php');
}
