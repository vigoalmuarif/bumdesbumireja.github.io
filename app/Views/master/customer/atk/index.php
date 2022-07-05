<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<button type="button" id="tambah" class="btn btn-primary float-right btn-sm">
    Tambah Pelanggan
</button>
<h1 class="h3 mb-2 text-gray-800">Pelanggan ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="card shadow mb-4">
    <div class="data-pelanggan"></div>
</div>
<div class="ubah-customer" style="display: none;"></div>
<div class="tambah-customer" style="display: none;"></div>



<script>
    function dataPelanggan() {
        $.ajax({
            type: "get",
            url: "<?= base_url('customer_atk/data_pelanggan') ?>",
            dataType: "json",
            success: function(response) {

                $(".data-pelanggan").html(response.view);

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    $(document).ready(function() {
        dataPelanggan(function() {

        });

    });
</script>

<?php $this->endSection() ?>