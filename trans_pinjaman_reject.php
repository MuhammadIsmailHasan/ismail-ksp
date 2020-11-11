<?php
include 'koneksi.php';
include 'functions.php';

$id = mysqli_escape_string($con, $_GET['id']);

$sql = "UPDATE pinjaman SET status = 'ditolak' WHERE id = '$id'";
mysqli_query($con, $sql) or die(mysqli_error(($con)));

header('location:trans_pinjaman.php');
