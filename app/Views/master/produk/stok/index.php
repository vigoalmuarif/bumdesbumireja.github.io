<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Stok Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php

use PhpParser\Node\Stmt\Foreach_;

if (session()->getFlashdata('pesan')) : ?>
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
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Stok Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    foreach ($produk as $products) : ?>
                        <tr>
                            <td> <?= $no++ ?></td>
                            <td> <?= $products['parent']['sku'] ?></td>
                            <td> <?= $products['parent']['produk'] ?></td>


                            <td><?= $products['stok_in']['stok_in'] == '' ? 0 : number_format($products['stok_in']['stok_in'], 0) . ' ' . $products['stok_in']['satuan'] ?></td>


                            <td><?= $products['stok_out']['stok_out'] == '' ? 0 : number_format($products['stok_out']['stok_out'], 0) . ' ' . $products['stok_out']['satuan'] ?></td>


                            <td><?= $products['harga']['qty_master'] == 0 ? 0 : number_format($products['harga']['qty_master'], 0) . ' ' . $products['harga']['satuan']  ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm historyStok" data-id="<?= $products['parent']['produkID']; ?>" data-satuan="<?= $products['parent']['satuan']; ?>"><i class="fa fa-history"></i></button>
                                <button type="button" class="btn btn-danger btn-sm kurangi-stok" data-id="<?= $products['parent']['produkID']; ?>"><i class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-history-stok" style="display: none;"></div>
<div class="modal-add-stok" style="display: none;"></div>
<div class="modal-less-stok" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $(".historyStok").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "post",
                url: "<?= base_url('produk/history_stok') ?>",
                data: {
                    id: id,
                    satuan: $(this).data('satuan')
                },
                dataType: "json",
                success: function(response) {
                    $(".modal-history-stok").html(response.view).show();
                    $("#modalHistoryStok").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".tambah-stok").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "post",
                url: "<?= base_url('produk/add_stok') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    $(".modal-add-stok").html(response.view).show();
                    $("#modalAddStok").modal('show');
                    $('#modalAddStok').on('shown.bs.modal', function(event) {
                        $("#jumlah").focus();
                    });

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".kurangi-stok").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "post",
                url: "<?= base_url('produk/less_stok') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {

                    $(".modal-less-stok").html(response.view).show();
                    $("#modalLessStok").modal('show');
                    $('#modalLessStok').on('shown.bs.modal', function(event) {
                        $("#jumlah").focus();
                    });

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    'title': 'Data Stok Produk ATK',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Stok Produk ATK',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>





<?php $this->endSection() ?>