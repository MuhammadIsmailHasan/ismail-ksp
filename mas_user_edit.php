<?php
include "header.php";
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = '$id'";
$sql = mysqli_query($con, $query) or die(mysqli_error($con));
$data = mysqli_fetch_array($sql);
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perubahan User</h1>
        <a href="mas_user.php" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="simpan_user.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password*</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Akses*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="akses" name="akses">
                            <option value="Kepala" <?php echo $data['akses'] == 'Kepala' ? 'selected' : '' ?>>Kepala</option>
                            <option value="Operator" <?php echo $data['akses'] == 'Operator' ? 'selected' : '' ?>>Operator</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-2">
                        <select name="status" id="status" class="form-control">
                            <option value="1" <?php echo $data['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?php echo $data['status'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success btn-user btn-block">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>