<?php $this->extend('templates/index_atk') ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<h1 class="h3 mb-2 text-gray-800">Ubah Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="row">
    <div class="col">
        <div class="card shadow-lg col-md-6 mx-auto">
            <h5 class="card-header text-center">From Ubah Produk ATK</h5>
            <div class="card-body">
                <form action="<?= base_url('produk/update/' . $produk['produkID']) ?>" method="post">


                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="hidden" name="old_sku" value="<?= $produk['sku'] ?>">
                        <input type="text" class="form-control  <?= $validation->hasError('sku') ? 'is-invalid' : '' ?>" value="<?= set_value('sku') ? set_value('sku') : $produk['sku'] ?>" name="sku" placeholder="Masukan SKU">
                        <div class="invalid-feedback">
                            <?= $validation->getError('sku'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control  <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama') ? set_value('nama') : $produk['produk'] ?>" name="nama" placeholder="Masukan nama">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control  <?= $validation->hasError('kategori') ? 'is-invalid' : '' ?>" id="kategori" name="kategori">
                            <option value="" disabled selected hidden>--Pilih--</option>
                            <?php foreach ($kategori as $catogory) : ?>
                                <option value="<?= $catogory['id'] ?>" <?= $produk['kategori_id'] == $catogory['id'] ? 'selected="selected"' : '' ?>><?= $catogory['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kategori'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <select class="form-control  <?= $validation->hasError('supplier') ? 'is-invalid' : '' ?>" id="supplier" name="supplier">
                            <option value="" selected disabled hidden>--Pilih--</option>
                            <?php foreach ($supplier as $suppliers) : ?>
                                <option value="<?= $suppliers['id'] ?>" <?= $produk['supplier_id'] == $suppliers['id'] ? 'selected="selected"' : '' ?>><?= $suppliers['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('supplier'); ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-md float-right mr-2">Ubah</button>
                    <a href="<?= base_url('produk/index') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $("#harga_beli").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $("#harga_jual").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $("#harga_stok").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
    });
</script>
<?php $this->endSection() ?>