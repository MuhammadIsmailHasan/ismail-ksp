<?php
    header("Access-Control-Allow-Origin: *");
    include "../koneksi.php";

    $uname = mysqli_escape_string($con, $_POST['username']);
	$pass = mysqli_escape_string($con, $_POST['password']);
	$pass_enc = md5($pass);

    $qry = "SELECT * FROM anggota WHERE username = '$uname' AND password = '$pass_enc' AND status = 1";
    $sql = mysqli_query($con, $qry);
    $isi = mysqli_fetch_assoc($sql);
    $jml = mysqli_num_rows($sql);

    $data = [];
    if ($jml == 0) {
        $data['status'] = 'error';
    } else {
        $data['status'] = 'ok';
        $data['data'] = $isi;
    }

    echo json_encode($data);
 ?>