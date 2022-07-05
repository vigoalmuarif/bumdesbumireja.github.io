<?= $this->extend('templates/index_retribusi'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Retribusi Pasar & Parkir</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="flash-data-error" data-error="<?= session()->getFlashdata('error') ?>"></div>

<div class="row">
    <div class="col">
        <div class="data-retribusi"></div>
    </div>
</div>

<script>
    function dataRetribusi() {
        $.ajax({
            type: "get",
            url: "<?= base_url('retribusi/data_retribusi') ?>",
            dataType: "json",
            success: function(response) {
                $(".data-retribusi").html(response.view);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataRetribusi();
    });
</script>

<?= $this->endSection() ?>