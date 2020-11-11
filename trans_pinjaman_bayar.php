<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Angsuran Pinjamaan Anggota</h1>
    </div>

    <?php
    if (isset($_GET['nik'])) {
        include "trans_pinjaman_bayar_detail.php";
    } else {
        include "trans_pinjaman_search.php";
    }
    ?>
</div>

<?php include "footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $('#modal_bayar').on('show.bs.modal', function(e) {
        $("#total").text("Rp. " + $(e.relatedTarget).data('total'));
        $('#id_bayar').val($(e.relatedTarget).data('id'));
        $('#denda_bayar').val($(e.relatedTarget).data('denda'));
        $('#nik').val($(e.relatedTarget).data('nik'));
    });
</script>