<?php
    $nik = ISSET($_GET['nik']) ? $_GET['nik'] : '-';
    $qry = "SELECT a.*, SUM(s.debet) - SUM(s.kredit) as saldo
              FROM anggota a
              LEFT JOIN simpanan s
                ON a.id = s.anggota_id
             WHERE a.nik = '$nik'
             GROUP BY a.id";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi = mysqli_fetch_assoc($sql);
    $jml = mysqli_num_rows($sql);

    $error = "";
    if ($isi == 0) {
        $error = "Data Anggota Tidak Ditemukan";
    }

    $qry = "SELECT s.*
              FROM simpanan s, anggota a
             WHERE a.id = s.anggota_id
               AND a.nik = '$nik'";
    $sql_simpanan = mysqli_query($con, $qry) or die(mysqli_error($con));

    $qry = "SELECT SUM(b.jumlah) as bunga
              FROM bunga b, simpanan s, anggota a
             WHERE b.simpanan_id = s.id
               AND s.anggota_id = a.id
               AND a.nik = '$nik'";
    $sql_bunga = mysqli_query($con, $qry) or die(mysqli_error($con));
    $isi_bunga = mysqli_fetch_assoc($sql_bunga);
?>
<?php if($error == "") { ?> 
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">NIK</label>
            <label class="col-sm-2 col-form-label"><?php echo $nik; ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama Anggota</label>
            <label class="col-sm-2 col-form-label"><?php echo $isi['nama']; ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Total Simpanan</label>
            <label class="col-sm-2 col-form-label">Rp. <?php echo number_format($isi['saldo']); ?></label>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Total Bunga</label>
            <label class="col-sm-2 col-form-label">Rp. <?php echo number_format($isi_bunga['bunga']); ?></label>
        </div>
    </div>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <label class="h5 mb-0 text-gray-800">Data Simpanan</label>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        type="button"
        data-toggle="modal"
        data-target="#modal_add"
        data-id="<?php echo $isi['id']; ?>">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
    </button>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th width="60px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($sim = mysqli_fetch_assoc($sql_simpanan)) { ?>
                        <tr>
                            <td><?php echo $sim['tanggal_debet']; ?>
                            <td><?php echo number_format($sim['debet']); ?>
                            <td><?php echo number_format($sim['kredit']); ?>
                            <td>
                                <button class="d-none d-sm-inline-block btn btn-sm btn-danger"
                                    type="button"
                                    title="Hapus Data"
                                    data-toggle="modal"
                                    data-target="#modal_delete"
                                    data-id="<?php echo $sim['id']; ?>">
                                    <i class="fa fa-trash fa-sm text-white-50"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } else { ?>
    <div class="card shadow mb-4">
    <div class="card-body">
        <?php echo $error; ?>
    </div>
</div>
<?php } ?>
<div id="modal_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_add" action="simpan_simpanan.php" method="post" class="modal-content">
            <div class="modal-header bg-primary-600">
                <h4 class="modal-title">Tambah Data Simpanan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Tanggal*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_add" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Jumlah*</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="debet_add" name="debet" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="id_add" name="id" value="<?php echo $isi['id']; ?>" />
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tutup</button>
                <button type="submit" class="btn btn-danger"><b><i class="fa fa-save"></i></b> Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal_delete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_delete" method="post" class="modal-content">
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-12">Anda yakin akan menghapus data ini?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tidak</button>
                <button type="submit" class="btn btn-danger"><b><i class="fa fa-trash"></i></b> Ya</button>
            </div>
        </form>
    </div>
</div>
