<?php $this->extend('templates/index_sewa') ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col">
        <div class="card shadow-lg">
            <h5 class="card-header text-center">From Tambah Property</h5>
            <div class="card-body">
                <form action="<?= base_url('property/save') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jenis_property">Jenis Property</label>
                            <select class="form-control  <?= $validation->hasError('jenis_property') ? 'is-invalid' : '' ?>" id="jenis_property" name="jenis_property">
                                <option value="">---Pilih---</option>
                                <option value="Kios" <?= set_value('jenis_property') == 'Kios' ? 'selected="selected"' : '' ?>>Kios Pasar</option>
                                <option value="Los" <?= set_value('jenis_property') == 'Los' ? 'selected="selected"' : '' ?>>Los Pasar</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_property'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kode_property">Kode Property</label>
                            <input type="text" class="form-control  <?= $validation->hasError('kode_property') ? 'is-invalid' : '' ?>" id="kode_property" value="<?= set_value('kode_property') ?>" name="kode_property" aria-describedby="kode_property" placeholder="Masukan kode property">
                            <div class="invalid-feedback">
                                <?= $validation->getError('kode_property'); ?>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="luas_tanah">Luas Tanah</label>
                            <div class="input-group">
                                <input type="text" class="form-control  <?= $validation->hasError('luas_tanah') ? 'is-invalid' : '' ?>" placeholder="Contoh 5 x 5" aria-label="Ex. 5 x 5" aria-describedby="basic-addon2" name="luas_tanah" value="<?= set_value('luas_tanah') ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m2</span>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('luas_tanah'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="luas_bangunan">Luas Bangunan</label>
                            <div class="input-group">
                                <input type="text" class="form-control  <?= $validation->hasError('luas_bangunan') ? 'is-invalid' : '' ?>" value="<?= set_value('luas_bangunan') ?>" placeholder="Contoh 3 X 4" name="luas_bangunan">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m2</span>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('luas_bangunan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="jangka">Tempo/Jangka</label>
                            <div class="input-group">
                                <input type="text" class="form-control  <?= $validation->hasError('jangka') ? 'is-invalid' : '' ?>" value="<?= set_value('jangka') ?>" placeholder="Contoh 33" name="jangka">
                                <div class="input-group-append">
                                    <span class="input-group-text">Tahun</span>
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jangka'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="harga">Harga</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control  <?= $validation->hasError('harga') ? 'is-invalid' : '' ?>" value="<?= set_value('harga') ?>" placeholder="Masukan harga" name="harga" id="harga">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('harga'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_property">Lokasi</label>
                            <input type="text" class="form-control  <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>" id="alamat" value="<?= set_value('alamat') ?>" name="alamat" aria-describedby="alamat" placeholder="Contoh : Blok A32">
                            <small class="form-text text-danger"><?= $validation->getError('alamat'); ?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fasilitas">Fasilitas</label>
                            <input class="form-control  <?= $validation->hasError('fasilitas') ? 'is-invalid' : '' ?>" id="fasilitas" name="fasilitas" placeholder="Masukan fasilitas" value="<?= set_value('fasilitas') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('fasilitas'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" placeholder="Masukan Keterangan jika ada" name="keterangan" rows="3"><?= set_value('keterangan') ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="gambar">Upload Gambar Jika Ada </label>
                                <input type="file" name="gambar" class="form-control-file <?= $validation->hasError('gambar') ? 'is-invalid' : '' ?>" id="gambar">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('gambar'); ?>
                                </div>
                                <small class="text-muted">Format Gambar : jpg, jpeg, png. Ukuran maks. 5Mb</small>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('property/index') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                    <button type="submit" class="btn btn-primary btn-md float-right mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $("#harga").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

    });
</script>
<?php $this->endSection() ?>