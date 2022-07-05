<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['atk', 'bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Ringkasan Laporan Harian</h6>
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
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th>Item</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Laba</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_item = 0;
                            $total_penjualan = 0;
                            $total_laba = 0;
                            foreach ($laporan as $row) :
                                $laba = ($row['jual'] - $row['beli']) * $row['qty'];
                                $status = $row['bayar'] - $row['total'];
                                $total_item += $row['jml'];
                                $total_penjualan += $row['total'];
                                $total_laba += $row['laba']
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                    <td><?= $row['faktur'] ?></td>
                                    <td><?= $row['customer'] ?></td>
                                    <td><?= $row['pembayaran'] ?></td>
                                    <td><?= $status >= 0 ? 'Lunas' : 'Belum Lunas'  ?></td>
                                    <td class="text-right angka"><?= number_format($row['jml'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['total'], 0) ?></td>
                                    <td class="text-right" id="laba"><?= number_format($row['laba'], 0) ?></td>


                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_item, 0, ',', ',') ?></th>
                                <th><?= number_format($total_penjualan, 0, ',', ',') ?></th>
                                <th><?= number_format($total_laba, 0, ',', ',') ?></th>
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
                    messageTop: 'Ringkasan Penjualan <?= $start . ' - ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }

                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Ringkasan Penjualan <?= $start . ' - ' . $end ?>',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'laporan penjualan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    customize: function(win) {
                        $(win.document.body).find('table tr td:nth-child(7)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(8)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(9)')
                            .css('text-align', 'right');
                        // $(win.document.body).find('table tfoot tr th')
                        //     .prop('colspan', '5');
                        $(win.document.body).find('table tfoot tr th:nth-child(7)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(8)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(9)')
                            .css('text-align', 'right');

                        $(win.document.body).find('table tfoot tr th:nth-child(1)')
                            .prop('colspan', '6')
                            .css('text-align', 'center')
                        $(win.document.body).find('table tfoot tr th:nth-child(2)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(3)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(4)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(5)')
                            .css('display', 'none');
                        $(win.document.body).find('table tfoot tr th:nth-child(6)')
                            .css('display', 'none');
                        // $(win.document.body).find('table tfoot tr th:nth-child(3)')
                        //     .css('display', 'none');
                        // $(win.document.body).find('tr.td')
                        //     .css('display', 'inherit');
                    }
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>