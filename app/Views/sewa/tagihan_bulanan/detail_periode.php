<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<?php endif; ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Tagihan Bulan <?= bulan_tahun(date('Y-m', strtotime($periode['periode']))) . ' ' . '(' . $periode['jenis'] . ')' ?></h6>
            </div>
            <div class="card-body">
                <div class="isi-periode"></div>

            </div>
        </div>
    </div>
</div>

<script>
    function isi_periode() {
        $.ajax({
            type: "post",
            url: "<?= base_url('persewaan/data_detail_periode') ?>",
            data: {
                periode: "<?= $periode['id'] ?>"
            },
            dataType: "json",
            success: function(response) {
                $(".isi-periode").html(response.view);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
    }


    $(document).ready(function() {
        isi_periode();
        $("#dataTable").dataTable();

    })
</script>


<?= $this->endSection() ?>