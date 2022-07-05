<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Riwayat Pembelian</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card">
    <div class="card-header">
        Daftar Pembelian
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Supplier</th>
                        <th>Total Harga</th>
                        <th>Bayar</th>
                        <th class="text-center">Status</th>
                        <th>Bukti</th>
                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($list as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d/m/Y', strtotime($row['date'])); ?></td>
                            <td><?= $row['faktur']; ?></td>
                            <td class="text-<?= $row['supplier'] == null ? 'center' : '' ?>"><?= $row['supplier'] != Null ? $row['supplier'] : '-';  ?></td>
                            <td>Rp <?= number_format($row['total'], 0, ",", ","); ?></td>
                            <td><?= $row['pembayaran'] ?></td>
                            <td class="text-center"><?= $row['bayar'] < ($row['total'] - $row['diskon']) ? '<span class="badge badge-outline-danger">Belum Lunas</span>' : '<span class="badge badge-outline-success">Lunas</span>' ?></td>
                            <td class="text-<?= empty($row['bukti']) ? 'center' : 'center'; ?>"><a href="/img/upload/<?= $row['bukti']; ?>" target="_blank"><?= empty($row['bukti']) ? '-' : 'Lihat Bukti'; ?></a></td>
                            <td class="text-center">
                                <button type="button" data-id="<?= $row['pembelian_id'] ?>" class="btn btn-info btn-sm setorRetribusi detail-pembelian">Detil</button>

                            </td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="pembelian"></div>
<div class="pelunasanHutang"></div>



<script>
    $(document).ready(function() {
        $("#dataTable").dataTable();
        $(".detail-pembelian").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('pembelian/detail_pembelian') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".pembelian").html(response.view);
                    $("#modalDetailPembelian").modal('show');

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".pelunasan-piutang").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/pelunasan') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".pelunasanPiutang").html(response.view);
                    $("#modalPelunasan").modal('show');

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>