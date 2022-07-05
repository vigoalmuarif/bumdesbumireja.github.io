<?php
if (in_groups(['admin', 'bendahara', 'atk'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<?php if (in_groups(['admin', 'bendahara', 'atk'])) : ?>
    <a href="<?= base_url('produk/create') ?>" class="btn btn-primary float-right btn-sm">
        Tambah Produk
    </a>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if (in_groups(['bendahara', 'atk'])) : ?>
            <div class="export float-right btn-sm" id="export"></div>
        <?php endif ?>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Dasar (Rp)</th>
                        <th>Jual (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($produk as $products) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $products['barcode']; ?></td>
                            <td><?= $products['sku']; ?></td>
                            <td><?= empty($products['nama_lain']) ? $products['produk'] : $products['nama_lain']; ?></td>
                            <td><?= $products['satuan'] ?></td>
                            <td class="text-<?= intval($products['qty'] / $products['isi']) ==  0 ? 'danger' : '' ?>"><b><?= intval($products['qty'] / $products['isi']) ?></b></td>
                            <td><?= number_format($products['harga_dasar'], 0, ",", ","); ?></td>
                            <td><?= number_format($products['harga_jual'], 0, ",", ","); ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    'title': 'Data Produk ATK',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Produk ATK',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>



<?php $this->endSection() ?>