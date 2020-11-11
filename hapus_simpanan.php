<?php
    include "koneksi.php";

    $id = mysqli_escape_string($con, $_GET['id']);
    $qry = "DELETE FROM bunga WHERE simpanan_id = '$id'";
    mysqli_query($con, $qry) or die(mysqli_error($con));

    $qry = "DELETE FROM simpanan WHERE id = '$id'";
    mysqli_query($con, $qry) or die(mysqli_error($con));
?>

<script>
    history.go(-1);
</script>