<?php
    include "header.php";
    $qry = "SELECT p.*, a.nama
              FROM pinjaman p
             INNER JOIN anggota a
                ON p.anggota_id = a.id
             WHERE p.status = 'pengajuan'";
    $sql = mysqli_query($con, $qry) or die(mysqli_error($con));

    $qryAnggota = "SELECT * FROM anggota";
    $sqlAnggota = mysqli_query($con, $qryAnggota) or die(mysqli_error($con));
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengajuan Pinjaman</h1>
    </div>

    <div class="text-right">
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal_add">
            <i class="fa fa-plus fa-sm"></i> Tambah Pinjaman
        </button>
    </div>
    <br/>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Lama Pinjaman</th>
                            <th>Cicilan per bulan</th>
                            <th>Status</th>
                            <th width="90px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data  = mysqli_fetch_array($sql)) {
                            ?>
                            <tr>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['jumlah_pinjaman']; ?></td>
                                <td><?php echo $data['lama_pinjaman']; ?></td>
                                <td><?php echo $data['cicilan_per_bulan']; ?></td>
                                <td><?php echo $data['status']; ?></td>
                                <td>
                                    <a href="trans_pinjaman_detail.php?id=<?php echo $data['id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning" title="Lihat Data"><i class="fa fa-desktop fa-sm"></i></a>
                                    <?php if ($data['status'] == 'pengajuan' && $_SESSION['auth_type'] == 'Kepala') { ?>
                                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary" type="button" title="Approve" data-toggle="modal" data-target="#modal_approve" data-id="<?php echo $data['id']; ?>" data-status="<?php echo $data['status']; ?>">
                                            <i class="fa fa-check fa-sm"></i>
                                        </button>
                                        <button class="d-none d-sm-inline-block btn btn-sm btn-danger" type="button" title="Reject" data-toggle="modal" data-target="#modal_reject" data-id="<?php echo $data['id']; ?>">
                                            <i class="fa fa-times fa-sm"></i>
                                        </button>
                                    <?php } else if ($data['status'] == 'diterima' && $_SESSION['auth_type'] == 'Operator') { ?>
                                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary" type="button" title="ACC" data-toggle="modal" data-target="#modal_acc" data-id="<?php echo $data['id']; ?>" data-status="<?php echo $data['status']; ?>">
                                            <i class="fa fa-check fa-sm"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_add" action="api/simpan_pinjaman.php" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pinjaman Baru</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Anggota</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id">
                            <?php while($anggota = mysqli_fetch_array($sqlAnggota)) {
                                echo "<option value='$anggota[id]'>$anggota[nama]</option>";
                            }?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jumlah Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="jumlah" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Lama Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="waktu" min="1" max="3" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="halaman" value="trans_pinjaman" />
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Batal</button>
                <button type="submit" class="btn btn-success"><b><i class="fa fa-save"></i></b> Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal_approve" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_approve" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Pinjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label>Anda yakin akan menyetujui pinjaman ini?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tidak</button>
                <button type="submit" class="btn btn-success"><b><i class="fa fa-check"></i></b> Ya</button>
            </div>
        </form>
    </div>
</div>
<div id="modal_acc" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_acc" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Pinjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label>Anda yakin akan meng-acc pinjaman ini?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tidak</button>
                <button type="submit" class="btn btn-success"><b><i class="fa fa-check"></i></b> Ya</button>
            </div>
        </form>
    </div>
</div>
<div id="modal_reject" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_reject" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Pinjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label>Anda yakin akan menolak pinjaman ini?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tidak</button>
                <button type="submit" class="btn btn-danger"><b><i class="fa fa-times"></i></b> Ya</button>
            </div>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    $('#modal_approve').on('show.bs.modal', function(e) {
        var status = "&status=";
        var url = "trans_pinjaman_approve.php?id=";
        url += $(e.relatedTarget).data('id');
        url += status += $(e.relatedTarget).data('status');
        $("#form_approve").prop('action', url);
    });
    $('#modal_acc').on('show.bs.modal', function(e) {
        var status = "&status=";
        var url = "trans_pinjaman_approve.php?id=";
        url += $(e.relatedTarget).data('id');
        url += status += $(e.relatedTarget).data('status');
        $("#form_acc").prop('action', url);
    });
    $('#modal_reject').on('show.bs.modal', function(e) {
        var url = "trans_pinjaman_reject.php?id=";
        url += $(e.relatedTarget).data('id');
        $("#form_reject").prop('action', url);
    });
</script>