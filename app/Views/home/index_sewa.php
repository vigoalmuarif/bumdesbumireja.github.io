<?php $this->extend('templates/index_sewa') ?>
<?= $this->section('content'); ?>
<?php if (in_groups('bendahara')) : ?>
    <div class="row">
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan Sewa</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_pendapatan_sewa['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendapatan Pajak</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pajak['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Sewa Belum lunas</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($sewa_belum_lunas['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-undo fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pajak belum lunas</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($bulanan_belum_lunas['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-undo fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="row">
    <div class="col-xl-3 col-md-12 mb-2">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Property Tersedia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $property_ready ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-store-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 mb-2">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Property disewa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $property_sewa ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-store-slash fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 mb-2">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pedagang Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pedagang_aktif ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 mb-2">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pedagang Non aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pedagang_nonaktif ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-slash fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary mt-2">Sewa Belum Lunas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pedagang</th>
                                <th>Property</th>
                                <th>Sewa</th>
                                <th>Selesai</th>
                                <th>Kekurangan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($sewa as $row) :
                                $kekurangan = $row['harga_sewa'] - $row['terbayar'];
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['pedagang']; ?></td>
                                    <td><?= $row['kode_property']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_sewa'])); ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_batas'])); ?></td>
                                    <td>Rp. <?= number_format($kekurangan, "0", ",", ",") ?></td>
                                    <?php if ($kekurangan >= 0 && strtotime(date('Y-m-d')) < strtotime($row['tanggal_batas'])) : ?>
                                        <td class="text-center"><span class="badge badge-outline-success">Aktif</span></td>
                                    <?php elseif ($kekurangan <= 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                                        <td class="text-center"><span class="badge badge-outline-biru">Selesai</span></td>
                                    <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                                        <td class="text-center"><span class="badge badge-outline-danger">Terlambat</span></td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Tagihan Bulanan Belum Lunas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableTagihan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Pedagang</th>
                                <th>Total Periode</th>
                                <th>Total Tarif</th>
                                <th>Total Bayar</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1; ?>
                            <?php foreach ($tagihan as $key) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $key['pedagang'] ?></td>
                                    <td><?= $key['bulan'] ?> Periode</td>
                                    <td>Rp. <?= number_format($key['totalTarif'], 0, '.', '.'); ?></td>
                                    <td>Rp. <?= number_format($key['bayar'], 0, '.', '.'); ?></td>
                                    <?php if ($key['bayar'] < $key['tarif']) : ?>
                                        <td class="text-center"><span class="badge badge-outline-danger">Belum Lunas</span></td>
                                    <?php else : ?>
                                        <td class="text-center"><span class="badge badge-outline-success">Lunas</span></td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#tableTagihan").dataTable();
    })
</script>
<?php $this->endSection() ?>