<?php
    include "koneksi.php";

    $id = mysqli_escape_string($con, $_GET['id']);
    $qry = "UPDATE periode SET status = 0 WHERE id = '$id'";
    mysqli_query($con, $qry) or die(mysqli_error($con));

    header('Location: set_periode.php');
?>