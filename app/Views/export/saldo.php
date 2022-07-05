<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        th,
        td {
            padding-left: 8px;
            padding-right: 8px;
            width: 50%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 12px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Laporan Saldo BUMDes Karsa Mandiri</h1>
    <h4 style="text-align: center;">Per tanggal <?= date_indo($tanggal); ?></h4>
    <br>
    <br>
    <br>
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
</body>

</html>