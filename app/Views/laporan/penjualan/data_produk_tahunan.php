<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['atk', 'bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Laporan Per Produk Tahun <?= $tahun ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Produk</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-right">Terjual</th>
                                <th class="text-right">Total (Rp)</th>
                                <th class="text-right">Laba (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_item = 0;
                            $total_produk = 0;
                            $total_laba = 0;
                            $omset = 0;
                            foreach ($laporan as $row) :
                                $total_item += $row['jml'];
                                $omset += $row['total_bayar'];
                                $total_laba += $row['laba']
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['sku'] ?></td>
                                    <td><?= empty($row['nama_lain']) ? $row['produk'] : $row['nama_lain'] ?></td>
                                    <td class="text-center"><?= $row['satuan'] ?></td>
                                    <td class="text-right" style="width: 130px;"><?= number_format($row['jml'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['total_bayar'], 0) ?></td>
                                    <td class="text-right"><?= number_format($row['laba'], 0) ?></td>


                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right"><?= number_format($total_item, 0, ',', ',') ?></th>
                                <th class="text-right"><?= number_format($omset, 0, ',', ',') ?></th>
                                <th class="text-right"><?= number_format($total_laba, 0, ',', ',') ?></th>
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
                    messageTop: 'Penjualan Per Produk Tahun <?= $tahun ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }

                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Penjualan Per Produk Tahun <?= $tahun ?>',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'laporan penjualan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    customize: function(win) {
                        $(win.document.body).find('table tr td:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(6)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tr td:nth-child(7)')
                            .css('text-align', 'right');


                        $(win.document.body).find('table tfoot tr th:nth-child(5)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(6)')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tfoot tr th:nth-child(7)')
                            .css('text-align', 'right');


                        $(win.document.body).find('table tfoot tr th:nth-child(1)')
                            .prop('colspan', '4')
                            .css('text-align', 'center');
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