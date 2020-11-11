<?php
    $qry = "SELECT a.*, SUM(s.debet) - SUM(s.kredit) as saldo
              FROM anggota a
              LEFT JOIN simpanan s
                ON a.id = s.anggota_id
             GROUP BY a.id";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="trans_simpanan.php" method="get" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nik" name="nik" required>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-user btn-block">
                Cari Data Anggota
            </button>
        </form>

        <p>&nbsp;</p>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>NIK Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Saldo</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($data  = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td><?php echo $data['nik']; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo number_format($data['saldo'], 0); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>