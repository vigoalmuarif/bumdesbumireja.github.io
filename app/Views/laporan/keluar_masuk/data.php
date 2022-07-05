<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2"><?= $jenis; ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Unit</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total = 0;
                            foreach ($laporan as $row) :
                                $total += $row['jumlah'];


                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-left">
                                        <?= date('d-m-Y', strtotime($row['created_at'])) ?>
                                    </td>
                                    <td><?= $row['jenis'] == 'in' ? "Masuk" : "Keluar" ?></td>
                                    <td><?= $row['unit'] ?></td>
                                    <td><?= $row['keterangan'] ?></td>
                                    <td class="text-right"><?= number_format($row['jumlah'], 0) ?></td>
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
                                <th><?= number_format($total, 0); ?></th>

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
                    title: 'Laporan <?= $jenis ?>',
                    messageTop: '<?= $jenis . ' untuk unit ' . $unit . ' dari ' . $start . ' sampai ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',


                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: '<?= $jenis . ' untuk unit ' . $unit . ' dari ' . $start . ' sampai ' . $end ?>',
                    messageBottom: window.location.href,
                    download: 'open',
                    text: '<i class="fas fa-file-pdf"></i> Print',
                    title: 'Laporan <?= $jenis ?>',


                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>