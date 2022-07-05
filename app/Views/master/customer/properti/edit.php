<?php $this->extend('templates/index_sewa') ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col col-md-7 m-auto">
        <div class="card shadow-lg">
            <h5 class="card-header text-center">From Ubah Pedagang</h5>
            <div class="card-body">
                <form action="<?= base_url('Pedagang/update/' . $customer['id']) ?>" method="post">
                    <div class="col">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control  <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" id="nama" value="<?= set_value('nama') ? set_value('nama') : $customer['nama'] ?>" name="nama" aria-describedby="nama" placeholder="Masukan nama lengkap">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <div class="input-group">
                                <input type="number" class="form-control  <?= $validation->hasError('nik') ? 'is-invalid' : '' ?>" placeholder="Masukan no KTP" aria-label="Ex. 5 x 5" aria-describedby="basic-nik" name="nik" value="<?= set_value('nik') ? set_value('nik') : $customer['nik']  ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nik'); ?>
                                </div>
                            </div>
                        </div>
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="jenis_kelamin" class="custom-control-input <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" value="L" <?= $customer['jenis_kelamin'] == 'L' ? 'checked="checked"' : '' ?>>
                                <label class="custom-control-label" for="customRadioInline1">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="jenis_kelamin" class="custom-control-input  <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>" value="P" <?= $customer['jenis_kelamin'] == 'P' ? 'checked="checked"' : '' ?>> <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
                                <div class="invalid-feedback col">
                                    <?= $validation->getError('jenis_kelamin'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control  <?= $validation->hasError('tempat_lahir') ? 'is-invalid' : '' ?>" id="tempat_lahir" name="tempat_lahir" value="<?= $customer['tempat_lahir'] ? $customer['tempat_lahir'] : set_value('tempat_lahir') ?>" placeholder="Masukan tempat lahir">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tempat_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control  <?= $validation->hasError('tanggal_lahir') ? 'is-invalid' : '' ?>" id="tempat_lahir" name="tanggal_lahir" value="<?= $customer['tanggal_lahir'] ? $customer['tanggal_lahir'] : set_value('tanggal_lahir') ?>" aria-describedby="tanggal_lahir">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control luas_bangunan  <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>" id="alamat" name="alamat" placeholder="Masukan alamat" aria-describedby="alamat"><?= $customer['alamat'] ? $customer['alamat'] : set_value('alamat') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Telepon / WhatsApp</label>
                            <input type="number" class="form-control  <?= $validation->hasError('no_hp') ? 'is-invalid' : '' ?>" id="no_hp" name="no_hp" value="<?= $customer['no_hp'] ? $customer['no_hp'] : set_value('no_hp') ?>" aria-describedby="no_hp" placeholder="Masukan no telp. atau whatsapp">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_usaha">jenis Usaha</label>
                            <input type="text" class="form-control  <?= $validation->hasError('jenis_usaha') ? 'is-invalid' : '' ?>" id="alamat" value="<?= $customer['jenis_usaha'] ? $customer['jenis_usaha'] : set_value('jenis_usaha') ?>" name="jenis_usaha" aria-describedby="jenis_usaha" placeholder="Masukan jenis_usaha">
                            <small class="form-text text-danger"><?= $validation->getError('jenis_usaha'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" <?= $customer['status'] == 1 ? 'selected="selected"' : '' ?>>Aktif</option>
                                <option value="0" <?= $customer['status'] == 0 ? 'selected="selected"' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <a href="<?= base_url('Pedagang/index') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                    <button type="submit" class="btn btn-primary btn-md float-right mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>