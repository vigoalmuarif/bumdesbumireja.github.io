<?php $this->extend('templates/index_atk') ?>
<?= $this->section('content'); ?>
<div class="row">

    <div class="col-xl-3 col-md-6 mb-2 penjualan-bulanan">
        <div class="card border-left-success shadow h-100 py-2">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Penjualan bulan ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($penjualan_bulanan['total'], 0, ',', ',') ?></div>
                    </div>
                    <div class="col-auto">
                        <a tabindex="1" class="" role="button"><i class="fas fa-wallet fa-2x text-success"></i></a>
                        <i class=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2 pembelian-bulanan">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pembelian bulan ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pembelian_bulanan['total'], 0, ',', ',') ?></div>
                    </div>
                    <div class="col-auto">
                        <a tabindex="1" class="" role="button"><i class="fas fa-cart-plus fa-2x text-warning"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-xl-3 col-md-6 mb-2 piutang">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Piutang Penjualan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($piutang, 0, ',', ',') ?></div>
                    </div>
                    <div class="col-auto">
                        <a tabindex="1" class="" role="button"><i class="fas fa-sign-in-alt fa-2x text-info"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2 hutang">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Hutang Pembelian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($hutang, 0, ',', ',') ?></div>
                    </div>
                    <div class="col-auto">
                        <a tabindex="1" class="" role="button"><i class="fas fa-sign-out-alt fa-2x text-danger"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" row mt-4 mb-5">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <canvas class="chart-penjualan" id="chartPenjualan"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Penjualan Hari Ini
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Faktur</th>
                                <th>customer</th>
                                <th>Total Harga</th>
                                <th>Pembayaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($penjualan as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['faktur'] ?></td>
                                    <td><?= $row['customer'] ?></td>
                                    <td>Rp <?= number_format($row['total'], 0, ',', ',') ?></td>
                                    <td><?= $row['pembayaran'] ?></td>
                                    <td class="text-center"><?= $row['bayar'] >= $row['total'] ? '<span class="badge badge-outline-success">Lunas</span>' : '<span class="badge badge-outline-danger">Belum Lunas</span' ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm detail-penjualan" data-id="<?= $row['penjualan_id'] ?>">Detail</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="detail" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $('.penjualan-bulanan').popover({
            trigger: 'focus',
            toggle: "popover",
            trigger: "focus",
            title: "Penjualan bulan ini",
            content: "Total penjualan pada bulan ini, baik pembayaran kredit maupun tunai."
        })
        $('.pembelian-bulanan').popover({
            trigger: 'focus',
            toggle: "popover",
            trigger: "focus",
            title: "pembelian bulan ini",
            content: "Total pembelian pada bulan ini, baik pembayaran kredit maupun tunai."
        })
        $('.piutang').popover({
            trigger: 'focus',
            toggle: "popover",
            trigger: "focus",
            title: "piutang",
            content: "Total piutang penjualan."
        })
        $('.hutang').popover({
            trigger: 'focus',
            toggle: "popover",
            trigger: "focus",
            title: "hutang",
            content: "Total hutang pembelian produk atk."
        })

        $(".detail-penjualan").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/detail_penjualan') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".detail").html(response.view).show();
                        $("#modalDetailPenjualan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
    var ctx = document.getElementById('chartPenjualan').getContext('2d');
    const penjualan = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($diagram as $row) {
                    echo "'" . bulan_tahun($row['date']) . "',";
                } ?>
            ],
            datasets: [{
                label: 'Penjualan Tahun <?= date('Y') ?>',
                backgroundColor: '#ADD8E6',
                pointBackgroundColor: "green",
                pointBorderColor: "green",
                hoverOffset: 4,
                fill: true,
                tension: 0.5,
                data: [
                    <?php foreach ($diagram as $row) {
                        echo "'" . $row['total'] . "',";
                    } ?>
                ],
            }]
        },

    });
</script>
<?php $this->endSection() ?>