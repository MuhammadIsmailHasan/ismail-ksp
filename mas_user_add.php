<?php include "header.php"; ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembuatan User Baru</h1>
        <a href="mas_user.php" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="simpan_user.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password*</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Akses*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="akses" name="akses">
                            <option value="Kepala">Kepala</option>
                            <option value="Operator">Operator</option>
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