<?php
    require __DIR__ . '/vendor/autoload.php';
    use Carbon\Carbon;

    include "koneksi.php";

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Tabungan.xls");

    $nik = $_GET['nik'];

    //1. Get Informasi Anggota
    $qry = "SELECT *
              FROM anggota
             WHERE nik = '$nik'";
    $sql_anggota = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi_anggota = mysqli_fetch_assoc($sql_anggota);

    $id_anggota = $isi_anggota['id'];
    $nama_anggota = $isi_anggota['nama'];

    //2. Get Periode
    $qry = "SELECT * FROM periode WHERE aktif = 1 and status = 1";
    $sql_periode = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi_periode = mysqli_fetch_assoc($sql_periode);

    $awal = new DateTime(Carbon::parse($isi_periode['awal'])->toDateTimeString());
    $akhir = new DateTime(Carbon::parse($isi_periode['akhir'])->addMonth(1)->toDateTimeString());
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($awal, $interval, $akhir);

    $bulan = [];
    foreach ($period as $dt) {
        $bulan[] = $dt;
    }

    $jumlahBulan = count($bulan);
?>

<table width="100%">
    <tr>
        <td>Nama</td>
        <td colspan="5">: <?php echo $nama_anggota; ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: <?php echo date('d'); ?></td>
        <td>Bulan</td>
        <td>: <?php echo date('m'); ?></td>
        <td>Tahun</td>
        <td>: <?php echo date('Y'); ?></td>
    </tr>
</table>

<p></p>

<table border="1" width="100%">
    <tr>
        <td rowspan="2" style="text-align: center">SAHAM TABUNGAN WAJIB</td>
        <td style="text-align: center">SAHAM</td>
        <td colspan="<?php echo $jumlahBulan - 1; ?>" style="text-align: center">BUNGA SAHAM</td>
        <td rowspan="2" style="text-align: center">JUMLAH BUNGA</td>
    </tr>
    <tr>
        <?php
            foreach ($bulan as $b)
            {
                echo "<td style='text-align: center'>" . $b->format("F Y") . "</td>";
            }
        ?>
    </tr>
    <?php
        $totalSaham = 0;
        $totalBunga = 0;
        foreach ($bulan as $row)
        {
            echo "<tr>";
            echo "<td>" . $row->format("F Y") . "</td>";

            $i=0;
            $jumlahBunga = 0;
            foreach ($bulan as $col)
            {
                if ($i == 0) {
                    $qry = "SELECT IFNULL(SUM(debet), 0) as debet
                              FROM simpanan
                             WHERE keterangan is null
                               AND anggota_id = '$id_anggota'
                               AND MONTH(tanggal_debet) = '". $row->format('m') ."'
                               AND YEAR(tanggal_debet) = '". $row->format('Y') ."'";
                    $sql_bulan = mysqli_query($con, $qry) or die(mysqli_error($con));
                    $isi_bulan = mysqli_fetch_assoc($sql_bulan);

                    $totalSaham += $isi_bulan['debet'];

                    echo "<td style='text-align: right'>". number_format($isi_bulan['debet'], 0) ."</td>";
                } else {
                    $qry = "SELECT IFNULL(SUM(jumlah), 0) as bunga
                              FROM bunga b, simpanan s
                             WHERE b.simpanan_id = s.id
                               AND s.keterangan is null
                               AND s.anggota_id = '$id_anggota'
                               AND MONTH(tanggal_debet) = '". $row->format('m') ."'
                               AND YEAR(tanggal_debet) = '". $row->format('Y') ."'
                               AND b.bulan = ". $col->format('m') ."
                               AND b.tahun = ". $col->format('Y');
                    $sql_bunga = mysqli_query($con, $qry) or die(mysqli_error($con));
                    $isi_bunga = mysqli_fetch_assoc($sql_bunga);

                    $jumlahBunga += $isi_bunga['bunga'];
                    echo "<td style='text-align: right'>". number_format($isi_bunga['bunga'], 0) ."</td>";
                }
                $i++;
            }
            $totalBunga += $jumlahBunga;
            echo "<td style='text-align: right'>". number_format($jumlahBunga, 0) ."</td>";
            echo "</tr>";
        }
    ?>
</table>

<p></p>

<table width="100%">
    <tr>
        <td colspan="4"><strong>TOTAL</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>TB</td>
        <td>+</td>
        <td>BT</td>
    </tr>
    <tr>
        <td style="text-align: right">=</td>
        <td>Rp. <?php echo number_format($totalSaham, 0) ?></td>
        <td>+</td>
        <td>Rp. <?php echo number_format($totalBunga, 0) ?></td>
    </tr>
    <tr>
        <td style="text-align: right">=</td>
        <td></td>
        <td></td>
        <td>Rp. <?php echo number_format($totalSaham + $totalBunga, 0) ?></td>
    </tr>
</table>
