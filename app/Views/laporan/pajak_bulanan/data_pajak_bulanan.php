<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Laporan Per Produk Bulan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pedagang</th>
                                <th>Sewa</th>
                                <th>Status</th>
                                <th>Tarif</th>
                                <th>Kekurangan</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_tarif = 0;
                            $total_bayar = 0;
                            $total_kekurangan = 0;
                            foreach ($laporan as $row) :
                                $status = $row['tarif'] - $row['bayarPajak'];
                                $total_tarif += $row['tarif'];
                                $total_bayar += $row['bayarPajak'] - $row['kembalian'];
                                $total_kekurangan += ($row['tarif'] - ($row['bayar'] - $row['kembalian']));

                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-left">
                                        <?= $row['pedagang'] ?>
                                    </td>
                                    <td><?= $row['jenis_property'] . ' (' . $row['kode_property'] . ')'  ?>
                                    </td>
                                    <td><?= $status > 0 ? 'Belum Lunas' : 'Lunas' ?></td>
                                    <td class="text-right"><?= number_format($row['tarif'], 0) ?></td>
                                    <td class="text-right"><?= number_format($status > 0 ? $status : '0', 0) ?></td>


                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_tarif, 0); ?></th>
                                <th><?= number_format($total_kekurangan, 0); ?></th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ubah-periode-bulanan"></div>

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    footer: true,
                    title: 'Laporan Pembayaran Pajak Bulanan',
                    messageTop: 'tagihan bulan <?= bulan_tahun($tahun . '-' . $bulan . '-01') ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }

                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'potrait',
                    footer: true,
                    messageTop: 'tagihan bulan <?= bulan_tahun($tahun . '-' . $bulan . '-01') ?>',
                    messageBottom: window.location.href,
                    download: 'open',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    title: 'Laporan Pembayaran Pajak Bulanan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },

                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>