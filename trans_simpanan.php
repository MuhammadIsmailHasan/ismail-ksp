<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Simpanan Anggota</h1>
    </div>

    <?php
        if(isset($_GET['nik'])) {
            include "trans_simpanan_detail.php";
        } else {
            include "trans_simpanan_search.php";
        }
    ?>
</div>

<?php include "footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

	$('#modal_delete').on('show.bs.modal', function(e){
		var url = "hapus_simpanan.php?id=";
		url += $(e.relatedTarget).data('id');
		$("#form_delete").prop('action', url);
	});	
</script>