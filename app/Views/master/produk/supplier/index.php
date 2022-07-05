<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<a href="<?= base_url('produk/create_supplier') ?>" class="btn btn-primary float-right btn-sm">
    Tambah Supplier
</a>
<h1 class="h3 mb-2 text-gray-800">Supplier Produk ATK</h1>
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
        <div class="export float-right btn-sm" id="export"></div>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Supplier Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($supplier as $suppliers) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $suppliers['nama']; ?></td>
                            <td><?= $suppliers['no_hp']; ?></td>
                            <td><?= $suppliers['alamat'] ?></td>
                            <td style="width: 118px;">
                                <a href="<?= base_url('produk/edit_supplier/' . $suppliers['id']) ?>" class="btn btn-info btn-sm" title="Edit">
                                    Ubah
                                </a>
                                <a href="<?= base_url('produk/delete_supplier/' . $suppliers['id']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin mengahpus Supplier <?= $suppliers['nama'] ?> ?')">
                                    Hapus
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
                    'title': 'Data Supplier',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Supplier',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                },
            ],
            "bDestroy": true

        });
        // table.destroy();

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>



<?php $this->endSection() ?>