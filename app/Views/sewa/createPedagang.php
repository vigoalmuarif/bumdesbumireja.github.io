<?php $this->extend('templates/index_sewa') ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col col-md-7 m-auto">
        <div class="card shadow-lg">
            <h5 class="card-header text-center">From Tambah Penyewa</h5>
            <div class="card-body">
                <form action="<?= base_url('sewa/savePedagang') ?>" method="post">
                    <div class="col">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control  <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" id="nama" value="<?= set_value('nama') ?>" name="nama" aria-describedby="nama" placeholder="Masukan nama lengkap">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <div class="input-group">
                                <input type="number" class="form-control  <?= $validation->hasError('nik') ? 'is-invalid' : '' ?>" placeholder="Masukan no KTP" aria-label="Ex. 5 x 5" aria-describedby="basic-nik" name="nik" value="<?= set_value('nik') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nik'); ?>
                                </div>
                            </div>
                        </div>
                        <label for="nama">Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="jenis_kelamin" class="custom-control-input <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" value="Laki-laki" <?= set_value('jenis_kelamin') == 'Laki-laki' ? 'checked="checked"' : '' ?>>
                                <label class="custom-control-label" for="customRadioInline1">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="jenis_kelamin" class="custom-control-input  <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" value="Perempuan" <?= set_value('jenis_kelamin') == 'Perempuan' ? 'checked="checked"' : '' ?>> <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
                                <div class="invalid-feedback col">
                                    <?= $validation->getError('jenis_kelamin'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control  <?= $validation->hasError('tempat_lahir') ? 'is-invalid' : '' ?>" id="no_hp" name="tempat_lahir" value="<?= set_value('tempat_lahir') ?>" aria-describedby="tempat_lahir" placeholder="Masukan tempat lahir">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tempat_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control  <?= $validation->hasError('tanggal_lahir') ? 'is-invalid' : '' ?>" id="no_hp" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" aria-describedby="tanggal_lahir" placeholder="Masukan tanggal lahir">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control luas_bangunan  <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>" id="sertifikat" name="alamat" placeholder="Masukan alamat" aria-describedby="alamat"><?= set_value('alamat') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Telepon / WhatsApp</label>
                            <input type="number" class="form-control  <?= $validation->hasError('no_hp') ? 'is-invalid' : '' ?>" id="no_hp" name="no_hp" value="<?= set_value('no_hp') ?>" aria-describedby="no_hp" placeholder="Masukan no telp. atau whatsapp">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_usaha">Jenis Usaha</label>
                            <input type="text" class="form-control  <?= $validation->hasError('pekerjaan') ? 'is-invalid' : '' ?>" id="jenis_usaha" value="<?= set_value('jenis_usaha') ?>" name="jenis_usaha" aria-describedby="jenis_usaha" placeholder="Masukan jenis_usaha">
                            <small class="form-text text-danger"><?= $validation->getError('jenis_usaha'); ?></small>
                        </div>
                    </div>
                    <a href="<?= base_url('sewa/create') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                    <button type="submit" class="btn btn-primary btn-md float-right mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>