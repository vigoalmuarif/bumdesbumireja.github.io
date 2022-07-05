<?= $this->extend('templates/index_sewa'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Periode Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>
    <?= session()->getFlashdata('error') ?>
<?php endif ?>


<div class="row">
    <div class="col">
        <div class="card mb-5">
            <div class="card-body">
                <form action="<?= base_url('persewaan/createPeriodeBulanan') ?>" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="custom-select <?= $validation->hasError('bulan') ? 'is-invalid' : '' ?>" name="bulan">
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
                                <select class="custom-select  <?= $validation->hasError('tahun') ? 'is-invalid' : '' ?>" name="tahun">
                                    <?= $start = 1980;
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
                        <div class="col-md-3">
                            <label for="exampleFormControlSelect1">Tarif</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="text" class="form-control <?= $validation->hasError('tarif') ? 'is-invalid' : '' ?>" name="tarif" value="<?= set_value('tarif') ?>" placeholder="Tarif">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tarif') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="exampleFormControlSelect1">Jenis</label>
                            <div class="form-group">
                                <select class="custom-select <?= $validation->hasError('jenis') ? 'is-invalid' : '' ?>" name="jenis">
                                    <option value="" disabled hidden selected>Pilih</option>
                                    <option value="Los" <?= set_value('jenis') == 'Los' ? 'selected="selected"' : ''; ?>>Los</option>
                                    <option value="Kios" <?= set_value('jenis') == 'Kios' ? 'selected="selected"' : ''; ?>>Kios</option>
                                    <option value="Semua" <?= set_value('jenis') == 'Semua' ? 'selected="selected"' : ''; ?>>Semua</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jenis') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-tambah">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="data-periode"></div>

<script>
    function periode_bulanan() {
        $.ajax({
            type: "get",
            url: "<?= base_url('persewaan/data_periode') ?>",
            dataType: "json",
            success: function(response) {
                $(".data-periode").html(response.view);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        periode_bulanan();
    })
</script>


<?= $this->endSection() ?>