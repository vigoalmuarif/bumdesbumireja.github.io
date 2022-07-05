<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Hutang Pembelian ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card">
    <div class="card-header">
        Daftar Hutang
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Total Harga (Rp)</th>
                        <th>Bayar (Rp)</th>
                        <th>Kekurangan (Rp)</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($hutang as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="<?= $row['supplier'] == '' ? 'text-center' : '' ?>"><?= $row['supplier'] == '' ? '-' : $row['supplier'] ?></td>
                            <td><?= number_format($row['totalHarga'], 0, ",", ","); ?></td>
                            <td><?= number_format($row['terbayar'], 0, ",", ","); ?></td>
                            <td><?= number_format($row['kekurangan'], 0, ",", ","); ?></td>
                            <td><?= $row['terbayar'] < $row['totalHarga'] ? '<span class="badge badge-outline-danger">Belum Lunas</span>' : '' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('pembelian/listhutang/' . $row['supplier_id']) ?>" class="btn btn-info btn-sm">Lihat</a>
                            </td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>