<?php
if (in_groups(['atk', 'bendahara'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr class="sidebar-divider d-none d-md-block">


<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-body">
                <form action="<?= base_url('laporan/penjualan/data_harian') ?>" method="post" id="laporan">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama">Mulai</label>
                                <input type="date" class="form-control" name="mulai" id="mulai" value="<?= set_value('mulai') ?>" autocomplete="off" required>
                                <div class="invalid-feedback error-mulai">

                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama">Sampai</label>
                                <input type="date" class="form-control" name="sampai" id="sampai" value="<?= set_value('sampai') ?>" autocomplete="off">
                                <div class="invalid-feedback error-sampai">

                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <button type="submit" id="filter" class="btn btn-primary btn-tambah">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="data-laporan"></div>

<script>
    $(document).ready(function() {

        $("#laporan").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".data-laporan").html(response.view).show();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?php $this->endSection() ?>