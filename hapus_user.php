<?php
include 'koneksi.php';
$id = mysqli_escape_string($con, $_GET['id']);
$sql = "UPDATE users SET status = '0' WHERE id = '$id'";
mysqli_query($con, $sql) or die(mysqli_error($con));

header('location:mas_user.php');
