<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara', 'atk'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Laporan Pembelian ATK <?= $start . ' - ' . $end ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>faktur</th>
                                <th>Supplier</th>
                                <th>Qty</th>
                                <th class="text-right">Sub Total</th>
                                <th class="text-right">Diskon</th>
                                <th class="text-right">Total Harga</th>
                                <th>Pembayaran</th>
                                <th>Kekurangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_item = 0;
                            $total_harga = 0;
                            $total_kekurangan = 0;
                            $total_bayar = 0;
                            $diskon = 0;
                            $sub_total = 0;
                            foreach ($laporan as $row) :
                                $kekurangan = ($row['totalHarga'] - $row['diskon']) - $row['bayar'];
                                $total_item += $row['jml'];
                                $sub_total += $row['totalHarga'];
                                $diskon += $row['diskon'];
                                $total_harga += ($row['totalHarga'] - $row['diskon']);
                                $total_kekurangan += $kekurangan;
                                $total_bayar += ($row['bayar'])
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                    <td><?= $row['faktur'] ?></td>
                                    <td><?= $row['supplier'] ?></td>
                                    <td class="text-right"><?= number_format($row['jml'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['totalHarga'], 0)  ?></td>
                                    <td class="text-right"><?= number_format($row['diskon'], 0)  ?></td>
                                    <td class="text-right"><?= number_format($row['totalHarga'] - $row['diskon'], 0)  ?></td>
                                    <td class="text-right"><?= number_format($row['bayar'], 0)  ?></td>
                                    <td class="text-right"><?= number_format($kekurangan, 0) ?></td>


                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_item, 0, ',', ',') ?></th>
                                <th><?= number_format($sub_total, 0, ',', ',') ?></th>
                                <th><?= number_format($diskon, 0, ',', ',') ?></th>
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
                    title: 'Laporan Pembelian',
                    messageTop: 'Hutang Pembelian <?= $start . ' - ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }

                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Hutang Pembelian <?= $start . ' - ' . $end ?>',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'laporan Pembelian',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
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
                        $(win.document.body).find('table tr td:nth-child(9)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(10)')
                            .css('text-align', 'right');


                        $(win.document.body).find('table tfoot tr th:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(6)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(7)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(8)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(9)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(10)')
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