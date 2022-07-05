<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara', 'atk'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Piutang Penjualan ATK Periode <?= $start . ' - ' . $end ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>faktur</th>
                                <th>Pelanggan</th>
                                <th>Item</th>
                                <th class="text-right">Total Harga</th>
                                <th class="text-right">Terbayar</th>
                                <th class="text-right">Kekurangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_item = 0;
                            $total_harga = 0;
                            $total_bayar = 0;
                            $total_kekurangan = 0;
                            foreach ($laporan as $row) :
                                $kekurangan = ($row['total'] - $row['bayar']);
                                $total_item +=  $row['jml'];
                                $total_harga +=  $row['totalHarga'];
                                $total_bayar +=  $row['bayar'];
                                $total_kekurangan +=  $kekurangan;
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                    <td><?= $row['faktur'] ?></td>
                                    <td><?= $row['customer'] ?></td>
                                    <td class="text-right angka"><?= number_format($row['jml'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['totalHarga'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['bayar'], 0) ?></td>
                                    <td class="text-right" id="laba"><?= number_format($kekurangan, 0) ?></td>


                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th>t</th>
                                <th>t</th>
                                <th>t</th>
                                <th><?= number_format($total_item, 0, ',', ',') ?></th>
                                <th><?= number_format($total_harga, 0, ',', ',') ?></th>
                                <th><?= number_format($total_bayar, 0, ',', ',') ?></th>
                                <th><?= number_format($total_kekurangan, 0, ',', ',') ?></th>
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
                    title: 'Laporan Penjualan',
                    messageTop: 'Piutang Penjualan <?= $start . ' - ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }

                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Piutang Penjualan <?= $start . ' - ' . $end ?>',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'laporan penjualan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    customize: function(win) {
                        $(win.document.body).find('table tr td:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(6)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(7)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(8)')
                            .css('text-align', 'right');
                        // $(win.document.body).find('table tfoot tr th')
                        //     .prop('colspan', '5');
                        $(win.document.body).find('table tfoot tr th:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(6)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(7)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(8)')
                            .css('text-align', 'right');

                        $(win.document.body).find('table tfoot tr th:nth-child(1)')
                            .prop('colspan', '4')
                            .css('text-align', 'center')
                        $(win.document.body).find('table tfoot tr th:nth-child(2)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(3)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(4)')
                            .css('display', 'none');


                    }
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>