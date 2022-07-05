<?php
if (in_groups(['bendahara'])) {
    echo $this->extend('templates/index');
}
?>
<?php $this->section('content') ?>

<?php if (isset($tanggal)) : ?>
    <form action="<?= base_url('export/saldo') ?>" method="get">
        <input type="hidden" value="<?= isset($tanggal) ? $tanggal : '' ?>" name="tanggal">
        <button class="btn btn-sm btn-info float-right d-block">Export</button>
    </form>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800 d-inline"><?= $title ?></h1>
<hr class="sidebar-divider d-none d-md-block">

<form action="<?= base_url('laporan/saldo/data'); ?>" method="get">
    <?php csrf_token(); ?>
    <div class="form-row">
        <div class="col col-md-3">
            <div class="form-group">
                <label for="">Per Tanggal</label>
                <input class="form-control" type="date" name="tanggal" required value="<?= isset($tanggal) ? $tanggal : '' ?>">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for=""></label>
                <button type="submit" class="btn btn-primary d-flex mt-2">Filter</button>
            </div>
        </div>

    </div>
</form>
<?php if (isset($tanggal)) : ?>
    <div class="alert alert-primary text-center mb-5" role="alert">Menampilkan saldo per tanggal <strong><?= date_indo($tanggal); ?></strong></div>
    <style>
        td,
        th {
            color: #1f1f1f;
        }

        td {
            width: 50%;
        }

        th {
            text-align: center;
        }
    </style>
    <div class=" card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: aquamarine;">
                        <tr>
                            <th class="text-center" colspan="2">Piutang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Penjualan ATK</td>
                            <td class="text-right"><?= number_format($penjualan - $transaksi_penjualan, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Sewa Kios & Los Pasar</td>
                            <td class="text-right"><?= number_format($sewa - $transaksi_sewa, 0); ?>
                        </tr>
                        <tr>
                            <td>Tagihan Bulanan Pasar & Los</td>
                            <td class="text-right"><?= number_format($pajak_bulanan - $transaksi_pajak_bulanan, 0); ?>
                        </tr>
                    </tbody>
                    <tfoot>
                        <?php
                        $total_piutang = (($penjualan - $transaksi_penjualan) + ($sewa - $transaksi_sewa) + ($pajak_bulanan - $transaksi_pajak_bulanan));
                        ?>
                        <tr>
                            <th class="text-center">Total</th>
                            <th class="text-right"><?= number_format($total_piutang, 0); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: lightgreen;">
                        <tr>
                            <th colspan="2">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Penjualan ATK</td>
                            <td class="text-right"><?= number_format($transaksi_penjualan, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Sewa Kios dan Los Pasar</td>
                            <td class="text-right"><?= number_format($transaksi_sewa, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Tagihan Rutin Bulanan</td>
                            <td class="text-right"><?= number_format($transaksi_pajak_bulanan, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Retribusi Pasar & Parkir</td>
                            <td class="text-right"><?= number_format($retribusi, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Pemasukan Lainnya</td>
                            <td class="text-right"><?= number_format($pemasukan_lainnya, 0); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <?php
                        $total_pemasukan = $transaksi_penjualan + $transaksi_sewa + $transaksi_pajak_bulanan + $retribusi + $pemasukan_lainnya;
                        ?>
                        <tr>
                            <th>Total</th>
                            <th class="text-right"><?= number_format($total_pemasukan, 0); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: lightcoral;">
                        <tr>
                            <th colspan="2">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Umum</td>
                            <td class="text-right"><?= number_format($pengeluaran_umum, 0); ?></td>
                        </tr>
                        <tr>
                            <td>ATK + Pembelian</td>
                            <td class="text-right"><?= number_format($pengeluaran_atk + $transaksi_pembelian, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Pasar</td>
                            <td class="text-right"><?= number_format($pengeluaran_pasar, 0); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <?php
                        $total_pengeluaran = $pengeluaran_umum + $pengeluaran_atk + $pengeluaran_pasar + $transaksi_pembelian;
                        ?>
                        <tr>
                            <th>Total</th>
                            <th class="text-right"><?= number_format($total_pengeluaran, 0); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color:mediumpurple;">
                        <tr>
                            <th colspan="2">Keuangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pendapatan + Piutang</td>
                            <td class="text-right"><?= number_format($total_pemasukan + $total_piutang, 0); ?></td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="text-right"><?= number_format($total_pengeluaran, 0); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong>Total</strong></td>
                            <td class="text-right"><strong><?= number_format((($total_pemasukan + $total_piutang) - $total_pengeluaran), 0); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: lightseagreen;">
                        <tr>
                            <th>Hutang</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">Hutang Pembelian ATK</td>
                            <td class="text-center">Pendapatan - Pengeluaran</td>
                        </tr>
                        <tr>
                            <td class="text-center"><b><?= number_format($pembelian - $transaksi_pembelian, 0); ?></b></td>
                            <td class="text-center"><b><?= number_format(($total_pemasukan - $total_pengeluaran), 0); ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif ?>
<?php $this->endSection(); ?>