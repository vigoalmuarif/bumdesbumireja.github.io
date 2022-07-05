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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Nama produk</th>
                                <th>Satuan</th>
                                <th>Total item</th>
                                <th class="text-right">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_item = 0;
                            $total_bayar = 0;

                            foreach ($laporan as $row) :

                                $total_item += $row['jml'];
                                $total_bayar += $row['subTotal'];

                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['sku'] ?></td>
                                    <td><?= $row['produk'] ?></td>
                                    <td><?= $row['satuan'] ?></td>
                                    <td class="text-right angka"><?= number_format($row['jml'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['subTotal'], 0) ?></td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">(Total bayar - Diskon)</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_item, 0, ',', ',') ?></th>
                                <th>(<?= number_format($total_bayar, 0) . ' - ' . number_format($diskon['diskon'], 0) . ') ' . number_format($total_bayar - $diskon['diskon'], 0); ?></th>
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
                    messageTop: 'Pembelian Per Produk <?= $start . ' - ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Pembelian Per Produk <?= $start . ' - ' . $end ?>',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'laporan Pembelian',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    customize: function(win) {
                        $(win.document.body).find('table tr td:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(6)')
                            .css('text-align', 'right');


                        $(win.document.body).find('table tfoot tr th:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(6)')
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