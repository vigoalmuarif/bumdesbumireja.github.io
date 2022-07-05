<?php $this->extend('templates/index') ?>
<?= $this->section('content'); ?>
<?php if (in_groups('admin')) : ?>
    <!-- Admin -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pegawai Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pegawai ?> Pegawai</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Petugas Retribusi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $petugas ?> Petugas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Users Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user ?> Users</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-out-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Riwayat Login Bulan <?= bulan_tahun('Y-m') ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>IP Address</th>
                                    <th>Email/Username</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($logins as $user) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $user['ip_address'] ?></td>
                                        <td><?= $user['emailLogin'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($user['date'])) ?></td>
                                        <td><?= $user['success'] == 1 ? 'Sukses' : 'Gagal' ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<!-- Bendahara -->
<?php if (in_groups('bendahara')) : ?>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Saldo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($saldo, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pengeluaran, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-out-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pendapatan bulan ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pendapatan_bulanan, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Pengeluaran Bulan ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pengeluaran_bulanan, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Belum Lunas (Piutang)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($piutang, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Hutang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($hutang, 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col col-md-6">
            <div class="card mb-4">
                <div class="card-header text-center">
                    Total Pendapatan
                </div>
                <div class="card-body">
                    <canvas id="pendapatan"></canvas>
                </div>
            </div>
        </div>

        <div class="col col-md-6">
            <div class="card mb-4">
                <div class="card-header text-center">
                    Total Pengeluaran
                </div>
                <div class="card-body">
                    <canvas id="pengeluaran"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<script>
    var ctx = document.getElementById('pendapatan').getContext('2d');
    const pendapatan = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'ATK',
                'Pasar',
                'Umum'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: ['<?= $pendapatan_atk ?>', '<?= $pendapatan_pasar ?>', '<?= $pendapatan_umum ?>'],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                    'rgb(52, 192, 235)'
                ],
                hoverOffset: 4
            }]
        },

    });
    var ctx = document.getElementById('pengeluaran').getContext('2d');
    const pengeluaran = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'ATK',
                'Pasar',
                'Umum'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: ['<?= $pengeluaran_atk ?>', '<?= $pengeluaran_pasar ?>', '<?= $pengeluaran_umum ?>'],
                backgroundColor: [
                    'rgb(29, 209, 167)',
                    'rgb(104, 215, 237)',
                    'rgb(237, 104, 197)'
                ],
                hoverOffset: 4
            }]
        },

    });
</script>

<?php $this->endSection() ?>