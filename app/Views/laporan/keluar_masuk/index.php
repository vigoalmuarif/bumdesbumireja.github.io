<?php
if (in_groups(['bendahara'])) {
    echo $this->extend('templates/index');
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
                <form action="<?= base_url('laporan/in_out/data_in_out') ?>" method="post" id="inOut">
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
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="custom-select <?= $validation->hasError('jenis') ? 'is-invalid' : '' ?>" name="jenis" required>
                                    <option value="" hidden disabled selected>Pilih</option>
                                    <option value="semua" <?= set_value('jenis') == 'semua' ? 'selected="selected"' : '' ?>>Semua</option>
                                    <option value="in" <?= set_value('jenis') == 'in' ? 'selected="selected"' : '' ?>>Pemasukan</option>
                                    <option value="out" <?= set_value('jenis') == 'out' ? 'selected="selected"' : '' ?>>Pengeluaran</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jenis') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select class="custom-select <?= $validation->hasError('unit') ? 'is-invalid' : '' ?>" name="unit" required>
                                    <option value="" hidden disabled selected>Pilih</option>
                                    <option value="semua" <?= set_value('unit') == 'semua' ? 'selected="selected"' : '' ?>>Semua</option>
                                    <option value="umum" <?= set_value('unit') == 'umum' ? 'selected="selected"' : '' ?>>Umum</option>
                                    <option value="pasar" <?= set_value('unit') == 'pasar' ? 'selected="selected"' : '' ?>>Pasar</option>
                                    <option value="atk" <?= set_value('unit') == 'atk' ? 'selected="selected"' : '' ?>>ATK</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('unit') ?>
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

        $("#inOut").submit(function(e) {
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