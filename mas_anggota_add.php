<?php include "header.php"; ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran Anggota Baru</h1>
        <a href="mas_anggota.php" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="simpan_anggota.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Scan KTP*</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="ktp" name="ktp" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIK*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No. Telepon*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jk" name="jk">
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
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
                    <label class="col-sm-2 col-form-label">Deposit Awal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="deposit" name="deposit" value="<?php echo number_format(100000, 0); ?>" readonly>
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