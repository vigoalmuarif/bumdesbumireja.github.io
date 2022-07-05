<?php
if (in_groups(['admin', 'bendahara', 'atk'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->

<?php
if ($count > 0) :

    if (in_groups(['admin', 'bendahara', 'atk'])) : ?>
        <button type="button" class="btn btn-primary float-right btn-sm" id="satuan-new">
            Tambah Satuan
        </button>
    <?php endif;  ?>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Satuan Harga Produk</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->

<div class="flash-data" data-flashdata="<?= session()->getFlashdata('flashdata') ?>"></div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if (in_groups(['bendahara', 'atk'])) : ?>
            <div class="export float-right btn-sm" id="export"></div>
        <?php endif ?>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Satuan Harga Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="form-row">

            <div class="form-group col">
                <label for="nama">Nama Produk</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?= $produk['sku'] . ' - ' . $produk['produk'] ?>" placeholder="Masukan nama" readonly>
                <div class="invalid-feedback error-nama">

                </div>
            </div>
            <div class="form-group col">
                <label for="kategori">kategori</label>
                <input type="text" class="form-control" name="kategori" id="kategori" value="<?= $produk['kategori'] ?>" placeholder="Masukan kategori" readonly>
                <div class="invalid-feedback error-kategori">

                </div>
            </div>
            <?php if ($produk['satuan'] !== null || 0 || '') : ?>
                <div class="form-group col">
                    <label for="satuan_dasar">Stok Awal</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="satuan_dasar" id="satuan_dasar" value="<?= $produk['stok_awal'] . ' ' . $produk['satuan'] ?>" placeholder="Masukan" readonly>
                        <?php if ($cekPembelian < 1) : ?>
                            <?php if ($produk['stok_awal'] == 0) : ?>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" name="stok-awal" id="stokAwal">Tambah</button>
                                </div>
                            <?php else : ?>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-warning" id="ubahStokAwal">Ubah</button>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
            <?php if ($produk['satuan'] != NULL || 0 || '') : ?>
                <div class="form-group col">
                    <label for="satuan_dasar">Satuan Dasar (Terkecil)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="satuan_dasar" id="satuan_dasar" value="<?= $produk['satuan'] ?>" placeholder="Masukan" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-warning" id="ubahSatuanDasar">Ubah</button>
                        </div>
                    </div>
                    <small class="text-muted">Tidak disarankan untuk mengubah</small>
                </div>
            <?php endif ?>

        </div>
        <!-- <table class="table table-borderless table-sm table-hover">
            <tbody>
                <tr>
                    <td>SKU</td>
                    <td>:</td>
                    <td><?= $produk['sku']; ?></td>
                </tr>
                <tr>
                    <td>Nama Produk</td>
                    <td>:</td>
                    <td><?= $produk['produk']; ?></td>
                </tr>
                <?php if ($produk['satuan'] != Null || 0 || '') : ?>
                    <tr>
                        <td>Satuan Dasar</td>
                        <td>:</td>
                        <td><?= $produk['satuan']; ?> <a role="button" type="button" class="badge badge-warning">Ubah</a></td>
                    </tr>
                <?php endif ?>

            </tbody>
        </table> -->

        <div class="table-responsive mt-4">
            <table class="table ">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Produk</th>
                        <th>Satuan</th>
                        <th>Isi</th>
                        <th>Harga Dasar (Rp)</th>
                        <th>Harga Jual (Rp)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (($produk['satuan'] == null) && ($count  < 1)) : ?>
                        <tr>
                            <td colspan="6" class="text-center" style="height: 180px; vertical-align:middle;"><button type="button" class="btn btn-success btn-sm tambah-satuan">Tambah Satuan</button></td>
                        </tr>
                        <?php else :
                        foreach ($harga as $price) : ?>
                            <tr>
                                <td class="text-<?= $price['barcode'] == '' ? 'center' : 'left' ?>"><?= $price['barcode'] == '' ? '-' : $price['barcode'] ?></td>
                                <td><?= empty($price['nama_lain']) ? $price['produk'] : $price['nama_lain']; ?></td>
                                <td><?= $price['satuan']; ?></td>
                                <td><?= $price['isi'] == 1 ? '' : $price['isi'] . ' ' . $produk['satuan'] ?></td>
                                <td><?= number_format($price['harga_dasar'], 0) . ' / ' . $price['satuan']; ?></td>
                                <td><?= number_format($price['harga_jual'], 0) . ' / ' . $price['satuan']; ?></td>
                                <td class="text-center">
                                    <button role="button" class="btn btn-warning btn-sm ubah-satuan-harga" data-id="<?= $price['hargaID']; ?>" data-satuan="<?= $price['satuan']; ?>"><i class="fa fas fa-edit"></i></button>

                                    <button role="button" class="btn btn-danger btn-sm hapus-satuan-harga" data-id="<?= $price['hargaID']; ?>" data-satuan="<?= $price['satuan']; ?>"><i class="fa fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="create-satuan-dasar"></div>
<div class="edit-satuan-dasar"></div>
<div class="create-new-harga"></div>
<div class="edit-satuan-harga"></div>
<div class="create-stok-awal"></div>
<div class="edit-stok-awal"></div>

<script>
    $(document).ready(function() {
        $("#stokAwal").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/create_stok_awal') ?>",
                data: {
                    id: "<?= $produk['produkID'] ?>",
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>",
                    satuanID: "<?= $produk['satuan_id'] ?>",
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".create-stok-awal").html(response.data);
                        $("#modalStokAwal").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $("#ubahStokAwal").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/edit_stok_awal') ?>",
                data: {
                    id: "<?= $produk['produkID'] ?>",
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>",
                    satuanID: "<?= $produk['satuan_id'] ?>",
                    stok_awal: "<?= $produk['stok_awal'] ?>",
                    qty: "<?= $produk['qty_master'] ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".create-stok-awal").html(response.data);
                        $("#modalEditStokAwal").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $(".tambah-satuan").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/create_satuan_dasar') ?>",
                data: {
                    id: "<?= $produk['produkID'] ?>",
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".create-satuan-dasar").html(response.data);
                        $("#modalSatuanDasar").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $("#ubahSatuanDasar").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/edit_satuan_dasar') ?>",
                data: {
                    id: "<?= $produk['produkID'] ?>",
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>",
                    satuanID: "<?= $produk['satuan_id'] ?>",
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".edit-satuan-dasar").html(response.data);
                        $("#modaEditSatuanDasar").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $(".ubah-satuan-harga").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/edit_satuan_harga') ?>",
                data: {
                    hargaID: $(this).data('id'),
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>",
                    satuanID: "<?= $produk['satuan_id'] ?>",
                    satuan_harga: $(this).data('satuan')
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".edit-satuan-harga").html(response.data);
                        $("#modalEditHarga").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })



        $("#satuan-new").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('produk/create_harga') ?>",
                data: {
                    id: "<?= $produk['produkID'] ?>",
                    sku: "<?= $produk['sku'] ?>",
                    produk: "<?= $produk['produk'] ?>",
                    satuan: "<?= $produk['satuan'] ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".create-new-harga").html(response.data).show();
                        $("#modalCreateHarga").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".hapus-satuan-harga").click(function(e) {
            let id = $(this).data('id');
            let satuan = $(this).data('satuan');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus satuan <b>${satuan}</b>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('produk/delete_satuan_harga') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.msg) {
                                window.location.reload();

                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            });
        })
    });
</script>

<?php $this->endSection() ?>