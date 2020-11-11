<?php
    include "header.php";

    $qry = "SELECT a.*, SUM(s.debet) - SUM(s.kredit) as saldo
                  FROM anggota a, simpanan s
                 WHERE a.id = s.anggota_id
                 GROUP BY a.id";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Tabungan</h1>
    </div>

    <div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>NIK Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Saldo</th>
                    <td width="80px">Aksi</td>
                </tr>
                </thead>
                <tbody>
                <?php while ($data  = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $data['nik']; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo number_format($data['saldo'], 0); ?></td>
                        <td>
                            <a href="download_tabungan.php?nik=<?php echo $data['nik']; ?>" class="btn btn-success" title="Download Laporan">
                                <i class="fa fa-download"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php include "footer.php"; ?>