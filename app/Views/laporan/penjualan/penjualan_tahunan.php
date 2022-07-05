<?php
if (in_groups(['atk', 'bendahara'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?php $this->section('content') ?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr class="sidebar-divider d-none d-md-block">
<div class="row">
    <div class="col">
        <div class="card mb-5">
            <div class="card-body">
                <form action="<?= base_url('laporan/penjualan/data_tahunan') ?>" method="post" id="laporan">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="custom-select  <?= $validation->hasError('tahun') ? 'is-invalid' : '' ?>" name="tahun" required>
                                    <?= $start = 2015;
                                    $end = date('Y');
                                    ?>
                                    <option value="" disabled hidden selected>Pilih</option>
                                    <?php for ($i = $end; $i >= $start; $i--) : ?>
                                        <option value="<?= $i ?>" <?= set_value('tahun') == $i ? 'selected="selected"' : '' ?>><?= $i ?></option>
                                    <?php endfor ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tahun') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-tambah">Filter</button>
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
    })
</script>
<?php $this->endSection() ?>