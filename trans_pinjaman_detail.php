<?php
include 'header.php';
$id = mysqli_escape_string($con, $_GET['id']);
$query = "SELECT p.*, a.nama 
            FROM pinjaman p 
            INNER JOIN anggota a 
            ON p.anggota_id = a.id 
            WHERE p.id = '$id'";
$sql = mysqli_query($con, $query) or die(mysqli_error($con));
$data = mysqli_fetch_assoc($sql);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Pinjaman</h1>
        <a href="trans_pinjaman.php" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Peminjam</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $data['nama']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jumlah Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['jumlah_pinjaman']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Lama Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['lama_pinjaman']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bunga Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['bunga_pinjaman']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Total Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['total_pinjaman']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cicilan Per Bulan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['cicilan_per_bulan']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Uang yang Diterima</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $data['uang_yang_diterima']; ?>" disabled>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>