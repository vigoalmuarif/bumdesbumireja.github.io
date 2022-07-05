<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Piutang Penjualan ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="row mt-4">
    <div class="col">

        <div class="card">
            <div class="card-header">
                Rincian Hutang <?= $customer['nama'] . ' [' . $customer['no_hp'] . ']' ?>
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
                                foreach ($list as $daftar) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $daftar['faktur'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($daftar['created_at'])) ?></td>
                                        <td class="text-right"><?= number_format($daftar['total'], 0, ',', ',') ?></td>
                                        <td class="text-right"><?= number_format($daftar['bayar'], 0, ',', ',') ?></td>
                                        <td class="text-right"><?= number_format($daftar['total'] - $daftar['bayar'], 0, ',', ',') ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info detail-piutang" data-id="<?= $daftar['penjualanID'] ?>">Detail</button>
                                            <button class="btn btn-sm btn-success bayar-piutang" data-id="<?= $daftar['penjualanID'] ?>">Bayar</button>
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
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>


<div class="piutang" style="display: none;"></div>
<div class="bayar"></div>


<script>
    $(document).ready(function() {
        $(".detail-piutang").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/detail_penjualan') ?>",
                data: {
                    id: id,
                    aksi: 1
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".piutang").html(response.view).show();
                        $("#modalDetailPenjualan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".bayar-piutang").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/bayar_piutang') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".bayar").html(response.view).show();
                        $("#modalBayarPiutang").modal('show');
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