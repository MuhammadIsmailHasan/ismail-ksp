<?php
    $qry = "SELECT p.*, a.nama, a.nik
                  FROM pinjaman p
                 INNER JOIN anggota a
                    ON p.anggota_id = a.id
                 WHERE p.status = 'selesai'";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="trans_pinjaman_bayar.php" method="get" enctype="multipart/form-data">
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
                    <th>NIK Peminjam</th>
                    <th>Nama Peminjam</th>
                    <th>Jumlah Pinjaman</th>
                    <th>Lama Pinjaman</th>
                    <th>Cicilan per bulan</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($data  = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td><?php echo $data['nik']; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['jumlah_pinjaman']; ?></td>
                        <td><?php echo $data['lama_pinjaman']; ?></td>
                        <td><?php echo $data['cicilan_per_bulan']; ?></td>
                        <td><?php echo $data['status']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>