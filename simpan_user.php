<?php
include 'koneksi.php';

$id = isset($_POST['id']) ? mysqli_escape_string($con, $_POST['id']) : '0';
$nama = mysqli_escape_string($con, $_POST['nama']);
$username = mysqli_escape_string($con, $_POST['username']);
$password = mysqli_escape_string($con, $_POST['password']);
$akses = mysqli_escape_string($con, $_POST['akses']);

if ($id == 0) {
    $password_enc = md5($password);
    $qry = "INSERT INTO users (nama, username, password, akses, status)
                VALUES ('$nama', '$username', '$password_enc', '$akses', '1')";
} else {
    $status = $_POST['status'];

    $qry_pass = '';
    if ($password != null) {
        $password_enc = md5($password);
        $qry_pass = ", password = '$password_enc'";
    }
    $qry = "UPDATE users
                   SET nama = '$nama',
                       username = '$username',
                       akses = '$akses',
                       status = '$status'
                       $qry_pass
                  WHERE id ='$id'";
}
mysqli_query($con, $qry) or die(mysqli_error($con));

header('location:mas_user.php');
