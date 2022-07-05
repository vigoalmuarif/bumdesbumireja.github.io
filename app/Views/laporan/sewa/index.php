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
                <form action="<?= base_url('laporan/sewa/data_sewa') ?>" method="post" id="laporanSewa">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="custom-select <?= $validation->hasError('jenis') ? 'is-invalid' : '' ?>" name="jenis" required>
                                    <option value="" hidden disabled selected>Pilih</option>
                                    <option value="semua" <?= set_value('jenis') == 'semua' ? 'selected="selected"' : '' ?>>Semua</option>
                                    <option value="Los" <?= set_value('jenis') == 'Los' ? 'selected="selected"' : '' ?>>Los Pasar</option>
                                    <option value="Kios" <?= set_value('jenis') == 'Kios' ? 'selected="selected"' : '' ?>>Kios Pasar</option>

                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bulan') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="custom-select  <?= $validation->hasError('status') ? 'is-invalid' : '' ?>" name="status" id="status" required>
                                    <option value="" disabled hidden selected>Pilih</option>
                                    <option value="semua">Semua</option>
                                    <option value="sewa_aktif">Sewa Aktif</option>
                                    <option value="sewa_lunas_aktif">Sewa Lunas (Aktif)</option>
                                    <option value="sewa_belum_lunas">Sewa Belum Lunas</option>
                                    <option value="sewa_selesai">Sewa Selesai</option>
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

        $("#laporanSewa").submit(function(e) {
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