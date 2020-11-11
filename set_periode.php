<?php
    include "header.php";
    $qry = "SELECT * FROM periode WHERE status = 1";
    $sql = mysqli_query($con, $qry) or die(myqli_error($con));
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Setting Periode</h1>
        <button type="button"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                data-toggle="modal"
                data-target="#modal_add">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Periode
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th>Aktif</th>
                            <th width="60px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($isi = mysqli_fetch_assoc($sql)) { ?>
                            <tr>
                                <td><?php echo $isi['nama']; ?>
                                <td><?php echo date('d M Y', strtotime($isi['awal'])); ?>
                                <td><?php echo date('d M Y', strtotime($isi['akhir'])); ?>
                                <td><?php echo $isi['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?>
                                <td>
                                    <button class="d-none d-sm-inline-block btn btn-sm btn-warning"
                                        type="button"
                                        title="Ubah Data"
                                        data-toggle="modal"
                                        data-target="#modal_update"
                                        data-id="<?php echo $isi['id']; ?>"
                                        data-nama="<?php echo $isi['nama']; ?>"
                                        data-awal="<?php echo $isi['awal']; ?>"
                                        data-akhir="<?php echo $isi['akhir']; ?>"
                                        data-aktif="<?php echo $isi['aktif']; ?>">
                                        <i class="fa fa-edit fa-sm text-white-50"></i>
                                    </button>
                                    <button class="d-none d-sm-inline-block btn btn-sm btn-danger"
                                        type="button"
                                        title="Hapus Data"
                                        data-toggle="modal"
                                        data-target="#modal_delete"
                                        data-id="<?php echo $isi['id']; ?>">
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
</div>

<div id="modal_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_add" action="simpan_periode.php" method="post" class="modal-content">
            <div class="modal-header bg-primary-600">
                <h4 class="modal-title">Tambah Data Periode</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Nama*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_add" name="nama" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Tanggal Awal*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="awal_add" name="awal" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Tanggal Akhir*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="akhir_add" name="akhir" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Aktif*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="aktif_add" name="aktif">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Tutup</button>
                <button type="submit" class="btn btn-danger"><b><i class="fa fa-save"></i></b> Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal_update" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_update" action="simpan_periode.php" method="post" class="modal-content">
            <div class="modal-header bg-primary-600">
                <h4 class="modal-title">Ubah Data Periode</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Nama*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_update" name="nama" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Tanggal Awal*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="awal_update" name="awal" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Tanggal Akhir*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="akhir_update" name="akhir" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group row">
                    <label class="control-label col-sm-2">Aktif*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="aktif_update" name="aktif">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="id_update" name="id" />
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


<?php include "footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

	$('#modal_update').on('show.bs.modal', function(e){
    	$("#id_update").val($(e.relatedTarget).data('id'));
    	$("#nama_update").val($(e.relatedTarget).data('nama'));
    	$("#awal_update").val($(e.relatedTarget).data('awal'));
    	$("#akhir_update").val($(e.relatedTarget).data('akhir'));
    	$("#aktif_update").val($(e.relatedTarget).data('aktif'));
	});	

	$('#modal_delete').on('show.bs.modal', function(e){
		var url = "hapus_periode.php?id=";
		url += $(e.relatedTarget).data('id');
		$("#form_delete").prop('action', url);
	});	
</script>