<style>
    .text-right {
        padding-right: 10px;
    }
</style>
<div class="row">
    <div class="col">
        <div class="alert alert-success text-center" role="alert">Menampilkan Laba tanggal <?= '<strong>' . date_indo($start) . '</strong> sampai tanggal <strong>' . date_indo($end) . '</strong>'; ?></div>
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('export/laba'); ?>" method="get">
                    <input type="hidden" value="<?= $start; ?>" name="mulai">
                    <input type="hidden" value="<?= $end; ?>" name="sampai">
                    <button type="submit" class="btn btn-sm btn-success float-right">Export</button>
                </form>
                <br>
                <br>
                <table class="table table-borderless col-md-8 mx-auto" style="border: 1px solid black;">
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-dark font-weight-bold bg-info">Penjualan ATK</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left pl-5 pt-5 font-weight-bold ">Penjualan Bersih</td>
                        </tr>
                        <tr>
                            <td class="pl-5">Diterima</td>
                            <td colspan="" class="text-right pr-5 "><?= number_format($penjualan_lunas['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="pl-5">Piutang</td>
                            <td colspan="" class="text-right pr-5 "><?= number_format($penjualan_belum_lunas['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="pl-5">Total</td>
                            <td class="text-right pr-5"><?= number_format(($penjualan_lunas['total'] + $penjualan_belum_lunas['total']), 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left font-weight-bold pl-5">Harga Pokok penjualan</td>
                            <td class="text-right pr-5"><?= number_format($hpp['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_kotor = (($penjualan_lunas['total'] + $penjualan_belum_lunas['total']) - $hpp['total']); ?>
                            <td colspan="2" class="text-left font-weight-bold pl-5">Laba Kotor</td>
                            <td class="text-right pr-5"><?= number_format($laba_kotor, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left font-weight-bold pl-5">Pengeluaran/Beban</td>
                            <td class="pr-5 text-right"><?= number_format($pengeluaran_atk['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_bersih = $laba_kotor - $pengeluaran_atk['total']; ?>
                            <td colspan="2" class="text-left font-weight-bold pl-5">Laba Bersih Operasional</td>
                            <td class="text-right pr-5"><?= number_format($laba_bersih, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 font-weight-bold">Pendapatan Lainnya</td>
                            <td class="text-right pr-5"><?= number_format($pendapatan_atk['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 pb-5 font-weight-bold">Laba Bersih</td>
                            <td class="text-right pr-5  pb-5"><?= number_format($laba_bersih + $pendapatan_atk['total'], 0) ?></td>
                        </tr>
                    </tbody>

                </table>

                <table class="table table-borderless mt-5 col-md-8 mx-auto" style="border: 1px solid black;">
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-dark font-weight-bold bg-success mt-4">Pengelolaan Pasar</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left font-weight-bold pl-5 pt-5">Pendapatan Sewa</td>
                        </tr>
                        <tr>
                            <td class="pl-5">Uang diterima</td>
                            <td colspan="" class="text-right"><?= number_format($uang_sewa_diterima['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="pl-5">Piutang</td>
                            <td colspan="" class="text-right"><?= number_format($piutang_sewa['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="pl-5">Total</td>
                            <?php $total_pendapatan_sewa = $uang_sewa_diterima['total'] + $piutang_sewa['total']; ?>
                            <td class="text-right pr-5"><?= number_format($total_pendapatan_sewa, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left pl-5 font-weight-bold">Pendapatan Pajak Bulanan</td>
                        </tr>
                        <tr>
                            <td class="pl-5">Uang diterima</td>
                            <td colspan="" class="text-right"><?= number_format($pajak_bulanan_terbayar['total_bayar_pajak'], 0); ?></td>
                        </tr>
                        <tr>
                            <td class="pl-5">Piutang</td>
                            <td colspan="" class="text-right"><?= number_format($pajak_bulanan['tarif'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="pl-5">Total</td>
                            <td class="text-right pr-5"><?= number_format($pajak_bulanan['tarif'], 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 font-weight-bold">Pendapatan Retribusi</td>
                            <td class="text-right pr-5"><?= number_format($retribusi['total']) ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_kotor = $total_pendapatan_sewa + $pajak_bulanan['tarif'] + $retribusi['total']; ?>
                            <td colspan="2" class="text-left pl-5 font-weight-bold"> Laba Kotor</td>
                            <td class="text-right pr-5"><?= number_format($laba_kotor, 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 font-weight-bold">Pengeluaran/Beban</td>
                            <td class="text-right pr-5"><?= number_format($pengeluaran_pasar['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 font-weight-bold">Laba Bersih Operasional</td>
                            <td class="text-right pr-5"><?= number_format($laba_kotor - $pengeluaran_pasar['total'], 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left pl-5 font-weight-bold">Pendapatan Lainnya</td>
                            <td class="text-right pr-5"><?= number_format($pendapatan_pasar['total'], 0); ?>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php $laba_bersih =  (($laba_kotor - $pengeluaran_pasar['total']) + $pendapatan_pasar['total']); ?>
                            <td colspan="2" class="text-left pl-5 pb-5 font-weight-bold">Laba Bersih</td>
                            <td class="text-right pr-5 pb-5"><?= number_format($laba_bersih + $pendapatan_pasar['total'], 0); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>