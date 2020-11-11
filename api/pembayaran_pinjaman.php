<?php
header("Access-Control-Allow-Origin: *");
include "../koneksi.php";
include "../functions.php";

// untuk simpan pinjaman
$id = isset($_POST['id']) ? mysqli_escape_string($con, $_POST['id']) : null;
$status = isset($_POST['status']) ? mysqli_escape_string($con, $_POST['status']) : null;

// untuk get pembayaran 
$nik = isset($_GET['nik']) ? mysqli_escape_string($con, $_GET['nik']) : null;
$data = [];

if ($id && $status != null) {
    if ($status == 'pengajuan') {
        $qry = "UPDATE pinjaman SET status = 'diterima' WHERE id = '$id'";
        $sql = mysqli_query($con, $qry) or die(mysqli_error(($con)));

        $data['Response'] = true;
        $data['Message'] = "Data pinjaman berhasil di update, menunggu ACC Operator";
    } else if ($status == 'diterima') {
        $tgl = date("Y-m-d");
        $sql_update = "UPDATE pinjaman 
                        SET status = 'selesai', 
                            tgl_acc = '$tgl' 
                        WHERE id = '$id'";
        mysqli_query($con, $sql_update) or die(mysqli_error(($con)));
        $getdata = getPinjamanById($con, $id);
        $angsuran = $getdata['lama_pinjaman'];
        $cicilan = $getdata['cicilan_per_bulan'];
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

        $data['Response'] = true;
        $data['Message'] = "Data pinjaman berhasil di ACC";
    }
} else if ($nik != null) {
    $pinjaman = "SELECT p.id FROM pinjaman p 
                    INNER JOIN anggota a 
                    ON p.anggota_id = a.id 
                WHERE a.nik = '$nik'";
    $sql = mysqli_query($con, $pinjaman) or die(mysqli_error($con));
    $pinjaman_id = mysqli_fetch_assoc($sql);
    $pinj_id = $pinjaman_id['id'];

    $ambil_pem_pin = "SELECT * FROM pembayaran_pinjaman WHERE pinjaman_id='$pinj_id'";
    $sql_data = mysqli_query($con, $ambil_pem_pin) or die(mysqli_error(($con)));
    if ($pinjaman = mysqli_fetch_assoc($sql_data) == null) {
        $data['Response'] = false;
        $data['Message'] = "Data pembayaran tidak di temukan";
    } else {
        $data_pinjaman = [];
        while ($pinjaman = mysqli_fetch_assoc($sql_data)) {
            array_push($data_pinjaman, $pinjaman);
        }
        $data['list pembayaran pinjaman'] = $data_pinjaman;
    }
} else {
    $data['Response'] = false;
    $data['Message'] = "Data tidak di temukan";
}
echo json_encode($data);
