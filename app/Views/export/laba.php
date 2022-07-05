<style>
    .judul {
        text-align: center;
        font-weight: bold;
        font-size: 26px;
        margin-bottom: 20px;
    }

    .sub-judul {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 45px;
    }

    table {
        width: 100%;
    }

    .header {
        background-color: gainsboro;
    }

    .th {
        text-align: center;
        font-weight: bold;
        padding-top: 30px;
    }

    .desc {
        padding-left: 20px;
    }

    .sub-desc {
        padding-left: 30px;
    }

    .nilai {
        padding-right: 20px;
        text-align: right;
    }

    .pertama {
        padding-top: 20px;
    }

    .last {
        padding-bottom: 20px;
    }

    .table-penjualan {
        page-break-after: auto;
        margin-bottom: 40px;
    }
</style>
<div class="row">
    <div class="col">
        <div class="judul">BUMDes Karsa Mandiri</div>
        <div class="alert alert-success text-center sub-judul" role="alert">Laporan Laba tanggal <?= '<strong>' . date_indo($start) . '</strong> sampai tanggal <strong>' . date_indo($end) . '</strong>'; ?></div>
        <div class="card">
            <div class="card-body">

                <table class="table-penjualan" style="border: 1px solid black;">
                    <tbody>
                        <tr class="header">
                            <th colspan="3" class="isi-header">Penjualan ATK</th>
                        </tr>
                        <tr>
                            <td colspan="3" class="desc pertama">Penjualan Bersih</td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Diterima</td>
                            <td colspan="" class="nilai"><?= number_format($penjualan_lunas['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Piutang</td>
                            <td colspan="" class="nilai"><?= number_format($penjualan_belum_lunas['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="sub-desc">Total</td>
                            <td class="nilai"><?= number_format(($penjualan_lunas['total'] + $penjualan_belum_lunas['total']), 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Harga Pokok penjualan</td>
                            <td class="nilai"><?= number_format($hpp['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_kotor = (($penjualan_lunas['total'] + $penjualan_belum_lunas['total']) - $hpp['total']); ?>
                            <td colspan="2" class="desc">Laba Kotor</td>
                            <td class="nilai"><?= number_format($laba_kotor, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Pengeluaran/Beban</td>
                            <td class="nilai"><?= number_format($pengeluaran_atk['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_bersih = $laba_kotor - $pengeluaran_atk['total']; ?>
                            <td colspan="2" class="desc">Laba Bersih Operasional</td>
                            <td class="nilai"><?= number_format($laba_bersih, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Pendapatan Lainnya</td>
                            <td class="nilai"><?= number_format($pendapatan_atk['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc last">Laba Bersih</td>
                            <td class="nilai last"><?= number_format($laba_bersih + $pendapatan_atk['total'], 0) ?></td>
                        </tr>
                    </tbody>

                </table>

                <table class="table table-pasar" style="border: 1px solid black;">
                    <tbody>
                        <tr class="header">
                            <th colspan="3" class="isi-header">Pengelolaan Pasar</th>
                        </tr>
                        <tr>
                            <td colspan="3" class="desc pertama">Pendapatan Sewa</td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Diterima</td>
                            <td colspan="" class="nilai"><?= number_format($uang_sewa_diterima['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Piutang</td>
                            <td colspan="" class="nilai"><?= number_format($piutang_sewa['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="sub-desc">Total</td>
                            <?php $total_pendapatan_sewa = $uang_sewa_diterima['total'] + $piutang_sewa['total']; ?>
                            <td class="nilai"><?= number_format($total_pendapatan_sewa, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="desc">Pendapatan Pajak Bulanan</td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Diterima</td>
                            <td colspan="" class="nilai"><?= number_format($pajak_bulanan_terbayar['total_bayar_pajak'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="sub-desc">Piutang</td>
                            <td colspan="" class="nilai"><?= number_format($pajak_bulanan['tarif'] - $pajak_bulanan_terbayar['total_bayar_pajak'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="sub-desc">Total</td>
                            <td class="nilai"><?= number_format($pajak_bulanan['tarif'], 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Pendapatan Retribusi</td>
                            <td class="nilai"><?= number_format($retribusi['total']) ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_kotor = $total_pendapatan_sewa + $pajak_bulanan['tarif'] + $retribusi['total']; ?>
                            <td colspan="2" class="desc"> Laba Kotor</td>
                            <td class="nilai"><?= number_format($laba_kotor, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Pengeluaran/Beban</td>
                            <td class="nilai"><?= number_format($pengeluaran_pasar['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Laba Bersih Operasional</td>
                            <td class="nilai"><?= number_format($laba_kotor - $pengeluaran_pasar['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="desc">Pendapatan Lainnya</td>
                            <td class="nilai"><?= number_format($pendapatan_pasar['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_bersih =  (($laba_kotor - $pengeluaran_pasar['total']) + $pendapatan_pasar['total']); ?>
                            <td colspan="2" class="desc last">Laba Bersih</td>
                            <td class="nilai last"><?= number_format($laba_bersih + $pendapatan_pasar['total'], 0); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>