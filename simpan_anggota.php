<?php
    include "koneksi.php";
    include "functions.php";

    $id = isset($_POST['id']) ? mysqli_escape_string($con, $_POST['id']) : '-';
	$nik = mysqli_escape_string($con, $_POST['nik']);
    $nama = mysqli_escape_string($con, $_POST['nama']);
    $alamat = mysqli_escape_string($con, $_POST['alamat']);
    $telepon = mysqli_escape_string($con, $_POST['telepon']);
    $jk = mysqli_escape_string($con, $_POST['jk']);
    $username = mysqli_escape_string($con, $_POST['username']);
    $password  = mysqli_escape_string($con, $_POST['password']);
    
    if ($id == '-') {
        $password_enc = md5($password);
        $nama_file = uploadKtp($_FILES['ktp']);
        $qry = "INSERT INTO anggota (ktp, nik, nama, alamat, telepon, jk, username, password)
                VALUES ('$nama_file', '$nik', '$nama', '$alamat', '$telepon', '$jk', '$username', '$password_enc')";
        mysqli_query($con, $qry) or die (mysqli_error($con));
    } else {
        $qry = "UPDATE anggota
                   SET nik = '$nik',
                       nama = '$nama',
                       alamat = '$alamat',
                       telepon = '$telepon',
                       jk = '$jk',
                       username = '$username'
                 WHERE id = $id";
        mysqli_query($con, $qry) or die (mysqli_error($con));

        if ($password != '') {
            $password_enc = md5($password);
            $qry = "UPDATE anggota SET password = '$password_enc' WHERE id = $id";
            mysqli_query($con, $qry) or die (mysqli_error($con));
        }

        if ($_FILES['ktp']['name'] != '') {
            $nama_file = uploadKtp($_FILES['ktp']);
            $qry = "UPDATE anggota SET ktp = '$nama_file' WHERE id = $id";
            mysqli_query($con, $qry) or die (mysqli_error($con));
        }
    }

    if ($id == '-') {
        $lastId = mysqli_insert_id($con);
        $periode = getPeriodeAktif($con);
        $tgl = date('Y-m-d');
        $qry = "INSERT INTO simpanan (periode_id, anggota_id, tanggal_debet, debet, keterangan)
                VALUES ('$periode', '$lastId', '$tgl', 100000, 'Saham Awal')";
        mysqli_query($con, $qry) or die (mysqli_error($con));
    }
    
    header('Location: mas_anggota.php');
?>

<?php
    function uploadKtp($file)
    {
        $nama_file = $file['name'];
        $tmp_file  = $file['tmp_name'];    
        $path      = "img/".$nama_file;
    
        move_uploaded_file($tmp_file, $path);
        return $nama_file;
    }
?>