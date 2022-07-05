<?php
if (in_groups(['admin', 'bendahara'])) {
    echo $this->extend('templates/index_sewa');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<?php if (in_groups(['admin', 'bendahara'])) : ?>
    <a href="<?= base_url('property/create') ?>" class="btn btn-primary float-right btn-sm">
        <i class="fa fas fa-plus"></i> Property
    </a>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Property</h1>
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
<?php $uri = service('uri');
if (in_groups('bendahara')) : ?>
    <div class="export float-right btn-sm" id="export"></div>

<?php endif ?>


<div class="btn-group mb-3" role="group" aria-label="Basic example">
    <a href="<?= base_url('property/type/semua') ?>" class="btn btn-outline-success mr-1 <?= $uri->getsegment(3) == 'semua' ? 'active' : '' ?>">Semua</a>
    <a href="<?= base_url('property/type/kios') ?>" class="btn btn-outline-warning  mr-1  <?= $uri->getsegment(3) == 'kios' ? 'active' : '' ?>">Kios</a>
    <a href="<?= base_url('property/type/los') ?>" class="btn btn-outline-danger  <?= $uri->getsegment(3) == 'los' ? 'active' : '' ?>">Los</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Property</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kode Property</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Jangka</th>
                        <th>Fasilitas</th>
                        <th class="text-center">Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($property as $properti) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            </td>
                            <td><?= $properti['kode_property']; ?>

                            </td>
                            <td><?= $properti['jenis_property']; ?></td>
                            <td>Rp. <?= number_format($properti['harga'], 0, ".", ".") ?></td>
                            <td><?= $properti['jangka']; ?> Tahun</td>
                            <td><?= $properti['fasilitas']; ?></td>
                            <td class="text-center"> <span class="badge <?= $properti['status'] == '1' ? 'badge-success' : 'badge-danger' ?>"><?= $properti['status'] == 1 ? 'Tersedia' : 'Disewa'; ?></span>
                            <td>
                                <a href="<?= base_url('property/detail/' . $properti['property_id']) ?>" class="btn btn-info btn-sm btn-block" title="Detail">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
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
                    'title': 'Data Property Pasar Bimireja',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Property Pasar Bimireja',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>

<?= $this->endSection() ?>