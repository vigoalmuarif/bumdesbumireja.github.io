<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Hutang Pembelian</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="row mt-4">
    <div class="col">

        <div class="card">
            <div class="card-header">
                Rincian Hutang pada Supplier <?= $supplier['supplier'] ?>
            </div>
            <div class="card-body">
                <?php if ($total['terbayar'] >= $total['totalHarga']) : ?>
                    <p class="text-center">Tidak ada piutang</p>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Faktur</th>
                                    <th>Tanggal</th>
                                    <th class="text-right">Total (Rp)</th>
                                    <th class="text-right">Terbayar (Rp)</th>
                                    <th class="text-right">Kekurangan (Rp)</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['faktur'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                                        <td class="text-right"><?= number_format($row['total'] - $row['diskon'], 0, ',', ',') ?></td>
                                        <td class="text-right"><?= number_format($row['bayar'], 0, ',', ',') ?></td>
                                        <td class="text-right"><?= number_format(($row['total'] - $row['diskon']) - $row['bayar'], 0, ',', ',') ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info detail-hutang" data-id="<?= $row['pembelianID'] ?>">Detail</button>
                                            <button class="btn btn-sm btn-success bayar-hutang" data-id="<?= $row['pembelianID'] ?>" <?= (($row['total'] - $row['diskon']) - $row['bayar']) == 0 ? 'disabled' : ''; ?>>Bayar</button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">Total</th>
                                    <th class="text-right"><?= number_format($total['totalHarga'], 0, ',', ',') ?></th>
                                    <th class="text-right"><?= number_format($total['terbayar'], 0, ',', ',') ?></th>
                                    <th class="text-right"><?= number_format($total['totalHarga'] - $total['terbayar'], 0, ',', ',') ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>


<div class="hutang" style="display: none;"></div>
<div class="bayar"></div>


<script>
    $(document).ready(function() {
        $(".detail-hutang").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('pembelian/detail_pembelian') ?>",
                data: {
                    id: id,
                    aksi: 1
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".hutang").html(response.view).show();
                        $("#modalDetailPembelian").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".bayar-hutang").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('pembelian/bayar_hutang') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".bayar").html(response.view).show();
                        $("#modalBayarHutang").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    })
</script>
<?php $this->endSection() ?>