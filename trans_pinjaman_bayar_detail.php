<?php
$nik = isset($_GET['nik']) ? $_GET['nik'] : '-';
$qry_data = "SELECT p.*, a.nama 
                FROM anggota a
                JOIN pinjaman p ON p.anggota_id = a.id 
            WHERE a.nik = '$nik' AND p.status = 'selesai'";
$sql_data = mysqli_query($con, $qry_data) or die(mysqli_error($con));
$data_pinjaman = mysqli_fetch_assoc($sql_data);
$pinjaman_id = $data_pinjaman['id'];

$qry_sisa = "SELECT COUNT(p.status) as sisa 
                FROM pembayaran_pinjaman p 
            WHERE pinjaman_id = '$pinjaman_id' AND status = 0";
$sql_sisa = mysqli_query($con, $qry_sisa) or die(mysqli_error($con));
$data_sisa = mysqli_fetch_assoc($sql_sisa);

$qry = "SELECT pp.*
            FROM anggota a
                JOIN pinjaman p 
                ON p.anggota_id = a.id
                JOIN pembayaran_pinjaman pp
                ON  pp.pinjaman_id = p.id
            WHERE a.nik = '$nik'";
$sql = mysqli_query($con, $qry) or die(mysqli_error($con));

$error = "";
if ($data_pinjaman == 0) {
    $error = "Data Pembayaran Tidak Ditemukan";
}

?>
<?php if ($error == "") { ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <label class="col-sm-2 col-form-label">: <?php echo $nik; ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Anggota</label>
                <label class="col-sm-2 col-form-label">: <?php echo $data_pinjaman['nama']; ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jumlah Pinjaman</label>
                <label class="col-sm-2 col-form-label">: Rp. <?php echo number_format($data_pinjaman['jumlah_pinjaman']); ?></label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Lama Pinjaman</label>
                <label class="col-sm-2 col-form-label">: <?php echo $data_pinjaman['lama_pinjaman']; ?> Bulan</label>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sisa Pembayaran Angsuran</label>
                <label class="col-sm-2 col-form-label">: <?php echo $data_sisa['sisa']; ?> Angsuran </label>
            </div>
        </div>
    </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="110px">Angsuran ke</th>
                            <th>Angsuran</th>
                            <th>Jatuh Tempo</th>
                            <th>Denda</th>
                            <th>Total Pembayaran</th>
                            <th width="60px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($sql)) {
                            $denda = 0;
                            $total = 0; ?>
                            <tr>
                                <td><?php echo $data['angsuran_ke']; ?>
                                <td>Rp. <?php echo number_format($data['jumlah']); ?>
                                <td><?php echo $data['jatuh_tempo']; ?>
                                <td><?php
                                    $tgl = date('Y-m-d');
                                    //$tgl = date('2019-08-26');
                                    if (strtotime($tgl) > strtotime($data['jatuh_tempo'])) {
                                        $denda = $data['jumlah'] * 0.05;
                                        ?>Rp. <?php echo number_format($denda);
                                                        } else {
                                                            echo number_format($data['denda']);
                                                        } ?>
                                </td>
                                <td>
                                    <?php $total = $data['jumlah'] + $denda;
                                    ?>Rp. <?php echo number_format($total); ?>
                                </td>
                                <td>
                                    <?php if ($data['status'] == 0) { ?>
                                        <?php if ($_SESSION['auth_type'] == 'Operator') { ?>
                                            <button class="d-none d-sm-inline-block btn btn-sm btn-primary" type="button" title="Bayar" data-toggle="modal" data-target="#modal_bayar" data-id="<?php echo $data['id']; ?>" data-total="<?php echo $total; ?>" data-denda="<?php echo $denda; ?>" data-nik="<?php echo $nik; ?>">
                                                <i class="fa fa-cash-register fa-sm"> Bayar</i>
                                            </button>
                                        <?php } else { ?>
                                            <i class="fa fa-sm"> Belum Lunas</i>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <i class="fa fa-check fa-sm"> Lunas</i>
                                    <?php } ?>
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
<div id="modal_bayar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form id="form_bayar" method="post" action="simpan_bayar.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembayaran Angsuran</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label>Jumlah Pembayaran : </label>
                    <h3 id="total"></h3>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_bayar" id="id_bayar">
                <input type="hidden" name="denda_bayar" id="denda_bayar">
                <input type="hidden" name="nik" id="nik">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><b><i class="fa fa-close"></i></b> Batal</button>
                <button type="submit" class="btn btn-primary"><b><i class="fa fa-check"></i></b> Bayar</button>
            </div>
        </form>
    </div>
</div>