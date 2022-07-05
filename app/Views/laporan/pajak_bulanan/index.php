<?php
if (in_groups(['bendahara'])) {
    echo $this->extend('templates/index_sewa');
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
                <form action="<?= base_url('laporan/sewa/data_pajak_bulanan') ?>" method="post" id="laporanPajak">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="custom-select <?= $validation->hasError('bulan') ? 'is-invalid' : '' ?>" name="bulan" required>
                                    <option value="" hidden disabled selected>Pilih</option>
                                    <option value="01" <?= set_value('bulan') == 1 ? 'selected="selected"' : '' ?>>Januari</option>
                                    <option value="02" <?= set_value('bulan') == 2 ? 'selected="selected"' : '' ?>>Februari</option>
                                    <option value="03" <?= set_value('bulan') == 3 ? 'selected="selected"' : '' ?>>Maret</option>
                                    <option value="04" <?= set_value('bulan') == 4 ? 'selected="selected"' : '' ?>>April</option>
                                    <option value="05" <?= set_value('bulan') == 5 ? 'selected="selected"' : '' ?>>Mei</option>
                                    <option value="06" <?= set_value('bulan') == 6 ? 'selected="selected"' : '' ?>>Juni</option>
                                    <option value="07" <?= set_value('bulan') == 7 ? 'selected="selected"' : '' ?>>Juli</option>
                                    <option value="08" <?= set_value('bulan') == 8 ? 'selected="selected"' : '' ?>>Agustus</option>
                                    <option value="09" <?= set_value('bulan') == 9 ? 'selected="selected"' : '' ?>>September</option>
                                    <option value="10" <?= set_value('bulan') == 10 ? 'selected="selected"' : '' ?>>Oktober</option>
                                    <option value="11" <?= set_value('bulan') == 11 ? 'selected="selected"' : '' ?>>November</option>
                                    <option value="12" <?= set_value('bulan') == 12 ? 'selected="selected"' : '' ?>>Desember</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bulan') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
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

        $("#laporanPajak").submit(function(e) {
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