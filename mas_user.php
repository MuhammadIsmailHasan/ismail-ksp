<?php
include "header.php";
$query = "SELECT * FROM users";
$sql = mysqli_query($con, $query) or die(mysqli_error($con));
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data User</h1>
        <a href="mas_user_add.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Akses</th>
                            <th>Status</th>
                            <th width="60px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data  = mysqli_fetch_array($sql)) {
                            ?>
                            <tr>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['username']; ?></td>
                                <td><?php echo $data['akses']; ?></td>
                                <td><?php
                                    if ($data['status'] == 1) {
                                        echo "Aktif";
                                    } else {
                                        echo "Tidak Aktif";
                                    } ?></td>
                                <td>
                                    <a href="mas_user_edit.php?id=<?php echo $data['id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning" title="Edit Data"><i class="fa fa-edit fa-sm"></i></a>
                                    <button class="d-none d-sm-inline-block btn btn-sm btn-danger" type="button" title="Hapus Data" data-toggle="modal" data-target="#modal_delete" data-id="<?php echo $data['id']; ?>">
                                        <i class="fa fa-trash fa-sm"></i>
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
    $('#modal_delete').on('show.bs.modal', function(e) {
        var url = "hapus_user.php?id=";
        url += $(e.relatedTarget).data('id');
        $("#form_delete").prop('action', url);
    });
</script>