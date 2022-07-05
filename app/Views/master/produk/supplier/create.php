<?= $this->extend('templates/index_atk'); ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<h1 class="h3 mb-2 text-gray-800">Tambah Supplier</h1>
<hr class="sidebar-divider d-none d-md-block">

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<a href="<?= base_url('produk/supplier') ?>" class="btn btn-primary btn-sm mb-2"><i class="fi-rr-arrow-left"> </i>Kembali</a>
<div class="row">
    <div class="col col-md-6 mx-auto">
        <div class="card shadow-lg">
            <h5 class="card-header text-center">From Tambah Supplier Produk ATK</h5>
            <div class="card-body">
                <form action="<?= base_url('produk/save_supplier') ?>" method="post">

                    <div class="form-group">
                        <label for="nama">Nama Perusahaan</label>
                        <input type="text" class="form-control  <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama') ?>" name="nama" placeholder="Masukan nama perusahaan">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Telepon</label>
                        <input type="text" class="form-control  <?= $validation->hasError('no_hp') ? 'is-invalid' : '' ?>" value="<?= set_value('no_hp') ?>" name="no_hp" placeholder="Masukan no telepon">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_hp'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control  <?= $validation->hasError('no_hp') ? 'is-invalid' : '' ?>" id="alamat" placeholder="Masukan alamat" name="alamat" rows="3"><?= set_value('alamat') ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamat'); ?>
                        </div>
                    </div>

                    <a href="<?= base_url('produk/supplier') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                    <button type="submit" class="btn btn-primary btn-md float-right mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>