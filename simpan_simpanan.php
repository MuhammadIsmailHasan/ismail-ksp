<?php
    require __DIR__ . '/vendor/autoload.php';
    use Carbon\Carbon;

    include "koneksi.php";
    include "functions.php";

	$id = mysqli_escape_string($con, $_POST['id']);
    $tanggal = mysqli_escape_string($con, $_POST['tanggal']);
    $debet = mysqli_escape_string($con, $_POST['debet']);
    
    //simpan data simpanan
    $periode = getPeriodeAktif($con);
    $qry = "INSERT INTO simpanan (anggota_id, periode_id, tanggal_debet, debet)
            VALUES ('$id', '$periode', '$tanggal', '$debet')";
    mysqli_query($con, $qry) or die (mysqli_error($con));

    //simpan data bunga
    $lastId = mysqli_insert_id($con);
    $awal = Carbon::parse($tanggal)->addMonth(1);
    $akhir = getAkhirPeriodeAktif($con);
    $lastBulan = 0;    
    while (strtotime($awal) <= strtotime($akhir)) {
        $bulan = date('m', strtotime($awal));
        $tahun = date('Y', strtotime($awal));

        if ($lastBulan != date('m', strtotime($awal))) {
            $lastBulan = $bulan;
            $bunga = 0.02 * $debet;

            $qry = "INSERT INTO bunga (simpanan_id, bulan, tahun, jumlah)
                    VALUES ('$lastId', '$bulan', '$tahun', '$bunga')";
            mysqli_query($con, $qry) or die (mysqli_error($con));
        }
        $awal = date ("Y-m-d", strtotime("+1 day", strtotime($awal)));
    }
?>

<script>
    history.go(-1);
</script>