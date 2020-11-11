<?php
    include "header.php";
    $qry = "SELECT * FROM anggota WHERE status = 1";
    $sql = mysqli_query($con, $qry) or die(myqli_error($con));
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Anggota</h1>
        <a href="mas_anggota_add.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Anggota</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th width="60px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($isi = mysqli_fetch_assoc($sql)) { ?>
                            <tr>
                                <td><?php echo $isi['nik']; ?>
                                <td><?php echo $isi['nama']; ?>
                                <td><?php echo $isi['alamat']; ?>
                                <td><?php echo $isi['telepon']; ?>
                                <td><?php echo $isi['jk']; ?>
                                <td>
                                    <a class="d-none d-sm-inline-block btn btn-sm btn-warning" href="mas_anggota_update.php?id=<?php echo $isi['id']; ?>"  title="Ubah Data"><i class="fa fa-edit fa-sm text-white-50"></i></a>
                                    <button class="d-none d-sm-inline-block btn btn-sm btn-danger"
                                        type="button"
                                        title="Hapus Data"
                                        data-toggle="modal"
                                        data-target="#modal_delete"
                                        data-id="<?php echo $isi['id']; ?>">
                                        <i class="fa fa-trash fa-sm text-white-50"></i>
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

	$('#modal_delete').on('show.bs.modal', function(e){
		var url = "hapus_anggota.php?id=";
		url += $(e.relatedTarget).data('id');
		$("#form_delete").prop('action', url);
	});	
</script>